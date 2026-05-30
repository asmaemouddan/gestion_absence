from fastapi import FastAPI, UploadFile, File
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI(title="Face Recognition Service")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def home():
    return {
        "message": "Face service is running"
    }

@app.post("/scan")
async def scan_face(image: UploadFile = File(...)):
    return {
        "status": "success",
        "filename": image.filename,
        "message": "Image received successfully"
    }
