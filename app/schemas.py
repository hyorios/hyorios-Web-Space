from pydantic import BaseModel
from typing import Optional

# --- User Schemas ---

# This is the schema for data we expect when a user signs up.
class UserCreate(BaseModel):
    email: str
    password: str

# This is the schema for data we can safely return to the client.
# It should NEVER include the password.
class User(BaseModel):
    id: int
    email: str

    class Config:
        orm_mode = True # This allows Pydantic to read the data from our ORM models (like models.User)

# --- Token Schemas ---

# This schema defines the structure of the access token we send back on login.
class Token(BaseModel):
    access_token: str
    token_type: str

# This schema defines the data we store inside the JWT.
class TokenData(BaseModel):
    email: Optional[str] = None

