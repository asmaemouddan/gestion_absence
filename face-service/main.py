from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse
from deepface import DeepFace
import numpy as np
import cv2
import base64

app = FastAPI()

MODEL_NAME = "ArcFace"
DETECTOR_BACKEND = "retinaface"
THRESHOLD = 0.68  # seuil ArcFace - va etre ajuste apres tests


def load_image(data):
    arr = np.frombuffer(data, np.uint8)
    return cv2.imdecode(arr, cv2.IMREAD_COLOR)


@app.post("/scan")
async def scan(request: Request):
    form = await request.form()

    photo_seance_file = form.get("photo_seance")
    if photo_seance_file is None:
        return JSONResponse({"error": "photo séance manquante"}, status_code=400)

    photo_seance = load_image(await photo_seance_file.read())

    # Extraire et encoder tous les visages de la photo de séance
    try:
        seance_faces = DeepFace.represent(
            img_path=photo_seance,
            model_name=MODEL_NAME,
            detector_backend=DETECTOR_BACKEND,
            enforce_detection=False,
            align=True
        )
    except Exception as e:
        print(f"Erreur extraction séance: {e}")
        seance_faces = []

    print(f"Nombre de visages détectés dans la séance: {len(seance_faces)}")
    seance_embeddings = [np.array(f["embedding"]) for f in seance_faces]

    absents = []

    for key in form.keys():
        if not key.startswith("etudiants["):
            continue

        etudiant_id = int(key.replace("etudiants[", "").replace("]", ""))
        file = form.get(key)
        image = load_image(await file.read())

        try:
            etudiant_faces = DeepFace.represent(
                img_path=image,
                model_name=MODEL_NAME,
                detector_backend=DETECTOR_BACKEND,
                enforce_detection=False,
                align=True
            )
        except Exception as e:
            print(f"Etudiant {etudiant_id}: erreur extraction profil - {e}")
            absents.append(etudiant_id)
            continue

        if len(etudiant_faces) == 0:
            print(f"Etudiant {etudiant_id}: aucun visage détecté sur sa photo de profil")
            absents.append(etudiant_id)
            continue

        etudiant_embedding = np.array(etudiant_faces[0]["embedding"])

        present = False
        best_distance = 999

        for seance_embedding in seance_embeddings:
            # distance cosine
            distance = 1 - np.dot(etudiant_embedding, seance_embedding) / (
                np.linalg.norm(etudiant_embedding) * np.linalg.norm(seance_embedding)
            )
            if distance < best_distance:
                best_distance = distance
            if distance <= THRESHOLD:
                present = True

        print(f"Etudiant {etudiant_id}: distance min = {best_distance:.3f} -> {'présent' if present else 'absent'}")

        if not present:
            absents.append(etudiant_id)

    return JSONResponse({"absents": absents})


@app.post("/debug")
async def debug(request: Request):
    form = await request.form()

    photo_seance_file = form.get("photo_seance")
    if photo_seance_file is None:
        return JSONResponse({"error": "photo séance manquante"}, status_code=400)

    photo_seance = load_image(await photo_seance_file.read())

    try:
        faces = DeepFace.extract_faces(
            img_path=photo_seance,
            detector_backend=DETECTOR_BACKEND,
            enforce_detection=False,
            align=True
        )
    except Exception as e:
        return JSONResponse({"error": str(e)}, status_code=500)

    crops_b64 = []
    for f in faces:
        face_img = (f["face"] * 255).astype(np.uint8)
        face_img = cv2.cvtColor(face_img, cv2.COLOR_RGB2BGR)
        _, buf = cv2.imencode(".jpg", face_img)
        crops_b64.append(base64.b64encode(buf).decode())

    return JSONResponse({"crops": crops_b64, "count": len(faces)})