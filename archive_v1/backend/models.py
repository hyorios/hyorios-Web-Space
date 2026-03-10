from sqlalchemy import Column, Integer, String
from .database import Base

# This is our ORM model. 
# It represents the 'users' table in our database.
class User(Base):
    __tablename__ = "users"

    # Define the columns of the table
    id = Column(Integer, primary_key=True, index=True)
    email = Column(String, unique=True, index=True, nullable=False)
    hashed_password = Column(String, nullable=False)

