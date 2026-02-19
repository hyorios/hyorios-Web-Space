from fastapi import FastAPI
from fastapi.staticfiles import StaticFiles
from fastapi.responses import FileResponse
from backend import models
from .database import engine
from .routers import authentication

# Create all database tables
models.Base.metadata.create_all(bind=engine)

app = FastAPI()

# Include API routers
app.include_router(authentication.router)

# Mount static file directories
app.mount("/js", StaticFiles(directory="frontend/js"), name="js")
app.mount("/css", StaticFiles(directory="frontend/css"), name="css")

# Serve HTML files
@app.get("/", response_class=FileResponse)
async def read_index():
    return "frontend/templates/index.html"

@app.get("/login", response_class=FileResponse)
async def read_login():
    return "frontend/templates/login.html"

@app.get("/register", response_class=FileResponse)
async def read_register():
    return "frontend/templates/register.html"

