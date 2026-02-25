# hyorios-Web-Space 🚀

Welcome to my personal digital space! This is a web application built from the ground up to be a canvas for creativity and experimentation.

## About

This project started as a simple "Walking Skeleton" - a minimal but functional FastAPI backend serving a basic HTML frontend. It's designed to evolve and grow with new features over time.

Built with the help of Agent Zero.

---

## Local Development Setup

Die Remote-Tunnel-Lösung hat sich als unzuverlässig erwiesen. Hier ist eine stabile Schritt-für-Schritt-Anleitung, um das Projekt direkt auf Ihrem lokalen Computer auszuführen.

### Voraussetzungen

- [Python 3.8+](https://www.python.org/downloads/)
- [pip](https://pip.pypa.io/en/stable/installation/) (wird normalerweise mit Python installiert)

### Schritt-für-Schritt-Anleitung

1.  **Öffnen Sie Ihr Terminal:**
    Starten Sie Ihre Kommandozeile (Terminal, PowerShell, Eingabeaufforderung etc.).

2.  **Navigieren Sie zum Projektverzeichnis:**
    Wechseln Sie mit dem `cd`-Befehl in den Projektordner.
    ```bash
    cd pfad/zu/hyorios-Web-Space
    ```

3.  **Virtuelle Umgebung erstellen und aktivieren:**
    Dies isoliert die Projekt-Abhängigkeiten von Ihrem System.
    ```bash
    # Umgebung erstellen
    python3 -m venv venv

    # Aktivieren (macOS/Linux)
    source venv/bin/activate

    # Aktivieren (Windows)
    .\venv\Scripts\activate
    ```
    *Sie erkennen die aktive Umgebung an dem `(venv)` vor Ihrer Kommandozeilen-Eingabe.*

4.  **Abhängigkeiten installieren:**
    Installieren Sie alle benötigten Python-Pakete mit einem einzigen Befehl.
    ```bash
    pip install -r requirements.txt
    ```

5.  **Webserver starten:**
    Starten Sie die FastAPI-Anwendung mit `uvicorn`.
    ```bash
    uvicorn app.main:app --host 0.0.0.0 --port 8000 --reload
    ```

6.  **Anwendung im Browser aufrufen:**
    Der Server läuft jetzt! Öffnen Sie Ihren Webbrowser und gehen Sie zu folgender Adresse:
    [http://localhost:8000](http://localhost:8000)

    Sie sollten nun die Web-Plattform sehen. Um den Server zu stoppen, wechseln Sie zurück ins Terminal und drücken `STRG+C`.

## Development Notes

- **2026-02-25:** Added CORS middleware to the FastAPI backend (`backend/main.py`) to resolve connection issues between the frontend and backend during local development.
