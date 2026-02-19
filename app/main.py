from fastapi import FastAPI
from fastapi.responses import FileResponse
from fastapi.staticfiles import StaticFiles
import os

# 1. Import the new components
from . import models
from .database import engine
from .routers import authentication

# 2. Create the database tables
# This line checks if the database and tables exist, and creates them if they don't.
# This is the magic that initializes our database based on the models.
models.Base.metadata.create_all(bind=engine)

# --- App Setup ---

# Use absolute paths to make the app runnable from anywhere
app_dir = os.path.dirname(os.path.abspath(__file__))
project_root = os.path.dirname(app_dir)
static_dir = os.path.join(project_root, "static")

app = FastAPI()

# 3. Include the authentication router
# This makes the /users/ and /token endpoints available in our application.
app.include_router(authentication.router)

# --- Static Files & Root Endpoint ---

# Mount the 'static' directory to serve our HTML, CSS, JS files
app.mount("/static", StaticFiles(directory=static_dir), name="static")

@app.get("/")
async def read_root():
    return FileResponse(os.path.join(static_dir, 'index.html'))

@app.get("/api/status")
async def get_status():
    return {"status": "ok", "message": "Backend is running!"}

