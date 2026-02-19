from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from sqlalchemy.ext.declarative import declarative_base

# 1. Define the database URL for SQLite.
# The database will be a file named 'hyorios_web_space.db' in the project root.
SQLALCHEMY_DATABASE_URL = "sqlite:///./hyorios_web_space.db"

# 2. Create the SQLAlchemy engine.
# The 'connect_args' is needed only for SQLite to allow multithreading as FastAPI runs in threads.
engine = create_engine(
    SQLALCHEMY_DATABASE_URL, connect_args={"check_same_thread": False}
)

# 3. Create a SessionLocal class.
# Each instance of a SessionLocal class will be a database session.
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

# 4. Create a Base class.
# Our ORM models (the classes that map to database tables) will inherit from this class.
Base = declarative_base()

# Dependency to get a DB session for each request and close it afterwards
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

