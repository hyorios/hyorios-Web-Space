from passlib.context import CryptContext
import hashlib

pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")

class Hash():
    @staticmethod
    def bcrypt(password: str):
        # Per user request, pre-hash with SHA-256 to handle long passwords
        # and then apply bcrypt.
        sha256_hashed_password = hashlib.sha256(password.encode()).hexdigest()
        return pwd_context.hash(sha256_hashed_password)

    @staticmethod
    def verify(plain_password: str, hashed_password: str):
        # Pre-hash the plain password with SHA-256 before verification
        sha256_hashed_plain_password = hashlib.sha256(plain_password.encode()).hexdigest()
        return pwd_context.verify(sha256_hashed_plain_password, hashed_password)
