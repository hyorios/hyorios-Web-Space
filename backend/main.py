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

# ---- CORS Middleware ----
# Allow all origins for development purposes. This should be restricted in production.
origins = ["*"]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


# ---- Frontend Setup ----
app.mount("/static", StaticFiles(directory="frontend"), name="static")

# Setup Jinja2 to find HTML templates in the 'frontend/templates' directory
templates = Jinja2Templates(directory="frontend/templates")

# ---- API Router ----
app.include_router(authentication.router)

# ---- HTML Page Routes ----
@app.get("/", response_class=HTMLResponse)
async def serve_home(request: Request):
    return templates.TemplateResponse("index.html", {"request": request})

@app.get("/login", response_class=HTMLResponse)
async def serve_login_page(request: Request):
    return templates.TemplateResponse("login.html", {"request": request})

@app.get("/register", response_class=HTMLResponse)
async def serve_register_page(request: Request):
    return templates.TemplateResponse("register.html", {"request": request})

# ---- API Test Route ----
@app.get("/api/status")
async def get_status():
    return {"message": "Backend is running!"}
