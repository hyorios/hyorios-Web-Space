from fastapi import FastAPI, Request
from fastapi.responses import HTMLResponse
from fastapi.staticfiles import StaticFiles
from fastapi.templating import Jinja2Templates

from .database import engine
from . import models
from .routers import authentication

# Create all database tables
models.Base.metadata.create_all(bind=engine)

app = FastAPI()

# --- Frontend Setup ---
# Mount the entire 'frontend' directory under the path '/static'
# This makes files like 'frontend/js/auth.js' available at 'http://.../static/js/auth.js'
app.mount("/static", StaticFiles(directory="frontend"), name="static")

# Setup Jinja2 to find HTML templates in the 'frontend/templates' directory
templates = Jinja2Templates(directory="frontend/templates")

# --- API Router ---
# Include the authentication routes (for /login, /token etc.)
app.include_router(authentication.router)


# --- HTML Page Routes ---
# These routes will serve the actual HTML pages

@app.get("/", response_class=HTMLResponse)
async def serve_home(request: Request):
    return templates.TemplateResponse("index.html", {"request": request})

@app.get("/login", response_class=HTMLResponse)
async def serve_login_page(request: Request):
    return templates.TemplateResponse("login.html", {"request": request})

@app.get("/register", response_class=HTMLResponse)
async def serve_register_page(request: Request):
    return templates.TemplateResponse("register.html", {"request": request})


# --- API Test Route for Frontend ---
@app.get("/api/status")
async def get_status():
    """A simple endpoint to confirm the backend is running."""
    return {"message": "Backend is running!"}
