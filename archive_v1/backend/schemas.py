from pydantic import BaseModel, Field

class UserCreate(BaseModel):
    email: str
    password: str = Field(..., min_length=4, max_length=30)

class User(BaseModel):
    email: str

    class Config:
        from_attributes = True

class Token(BaseModel):
    access_token: str
    token_type: str
