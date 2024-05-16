from cryptography.fernet import Fernet


def key_generator():
    key = Fernet.generate_key()
    with open("crypt.key", "wb") as f:
        f.write(key)
    return key

def load_key():
    # ask for the key
    with open("crypt.key", "rb") as f:
        print("Chiave caricata con successo")
        return f.read()

def crypt_file(key,path):
    # opening the original file to encrypt
    with open(path, 'rb') as file:
        original = file.read()

    # encrypting the file
    fernet = Fernet(key)
    encrypted = fernet.encrypt(original)

    # opening the file in write mode and 
    # writing the encrypted data
    with open(path, 'wb') as encrypted_file:
        encrypted_file.write(encrypted)
    print("File criptato")

def decrypt_file(key,path):
    # opening the encrypted file
    with open(path, 'rb') as f:
        encrypted = f.read()
    fernet = Fernet(key)
    decrypt_data = fernet.decrypt(encrypted)
    with open(path, 'wb') as f:
        f.write(decrypt_data)
    print("File decriptato")
    
def main():
    path = input("Dammi il path del file")
    choice = input("Hai già una chiave segreta? (Sì/No): ").strip().upper()
    if choice == "SI":
        key = load_key()
    elif choice == "NO":
        print("\nGenerata nella cartella corrente la tua chiave segreta.")
        key = key_generator()
    else:
        print("Opzione non valida.")
        main()

    while True:
        print("\nMenu:")
        print("1. Cripta")
        print("2. Decripta")
        print("3. Esci")
        choice = input("Scegli un'opzione (1/2/3): \n").strip()

        if choice == "1":
            crypt_file(key,path)
        elif choice == "2":
            decrypt_file(key,path)
        elif choice == "3":
            print("See ya")
            break

if __name__ == "__main__":
    main()