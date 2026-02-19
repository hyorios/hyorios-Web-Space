from fastapi import APIRouter, Depends, HTTPException, status
from fastapi.security import OAuth2PasswordRequestForm
from sqlalchemy.orm import Session
from sqlalchemy.exc import IntegrityError
from .. import database, models, schemas
from ..hashing import Hash
from ..token import create_access_token

router = APIRouter(
    tags=['Authentication']
)

@router.post('/users/', status_code=status.HTTP_201_CREATED)
def create_user(request: schemas.UserCreate, db: Session = Depends(database.get_db)):
    new_user = models.User(email=request.email, password=Hash.bcrypt(request.password))
    db.add(new_user)
    try:
        db.commit()
    except IntegrityError:
        db.rollback()
        raise HTTPException(status_code=status.HTTP_400_BAD_REQUEST,
                            detail=f"User with email '{request.email}' already exists.")
    db.refresh(new_user)
    return new_user

@router.post('/token')
def login(request: OAuth2PasswordRequestForm = Depends(), db: Session = Depends(database.get_db)):
    user = db.query(models.User).filter(models.User.email == request.username).first()
    if not user:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND,
                            detail=f"Invalid Credentials")
    if not Hash.verify(user.password, request.password):
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND,
                            detail=f"Incorrect password")

    access_token = create_access_token(data={"sub": user.email})
    return {"access_token": access_token, "token_type": "bearer"}
