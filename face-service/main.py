
from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse
import face_recognition
import numpy as np
import cv2

app = FastAPI()

TOLERANCE = 0.47


def load_image(data):
    arr = np.frombuffer(data, np.uint8)
    return cv2.imdecode(arr, cv2.IMREAD_COLOR)


@app.post("/scan")
async def scan(request: Request):

    form = await request.form()

    photo_seance_file = form.get("photo_seance")

    if photo_seance_file is None:
        return JSONResponse(
            {"error": "Photo séance manquante"},
            status_code=400
        )

    photo_seance = load_image(await photo_seance_file.read())

    photo_seance_rgb = cv2.cvtColor(
        photo_seance,
        cv2.COLOR_BGR2RGB
    )

    seance_encodings = face_recognition.face_encodings(
        photo_seance_rgb
    )

    print(f"Nombre de visages détectés dans la séance: {len(seance_encodings)}")

    absents = []

    for key in form.keys():

        if not key.startswith("etudiants["):
            continue

        etudiant_id = int(
            key.replace("etudiants[", "").replace("]", "")
        )

        file = form.get(key)

        image = load_image(await file.read())

        image_rgb = cv2.cvtColor(
            image,
            cv2.COLOR_BGR2RGB
        )

        encodings = face_recognition.face_encodings(image_rgb)

        if len(encodings) == 0:
            absents.append(etudiant_id)
            continue

        etudiant_encoding = encodings[0]

        present = False
        best_distance = 1.0

        for face_encoding in seance_encodings:

            distance = face_recognition.face_distance(
                [face_encoding],
                etudiant_encoding
            )[0]

            best_distance = min(
                best_distance,
                distance
            )

            if distance <= TOLERANCE:
                present = True
                break

        print(
            f"Etudiant {etudiant_id}: "
            f"distance min = {best_distance:.3f} -> "
            f"{'présent' if present else 'absent'}"
        )

        if not present:
            absents.append(etudiant_id)

    return JSONResponse({
        "absents": absents
    })
