from fastapi import FastAPI
from fastapi.responses import FileResponse
from fastapi.staticfiles import StaticFiles
import os

# Use absolute paths to make the app runnable from anywhere
app_dir = os.path.dirname(os.path.abspath(__file__))
project_root = os.path.dirname(app_dir)
static_dir = os.path.join(project_root, "static")

app = FastAPI()

# Mount the 'static' directory to serve our HTML, CSS, JS files
app.mount("/static", StaticFiles(directory=static_dir), name="static")

@app.get("/")
async def read_root():
    return FileResponse(os.path.join(static_dir, 'index.html'))

@app.get("/api/status")
async def get_status():
    return {"status": "ok", "message": "Backend is running!"}
