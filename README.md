# AudioSeg

## Commands to access venv

To create venv (on the dir that you want)
python -m venv .venv

To activate the venv
Windows: .\.venv\Scripts\Activate.ps1
Linux: source .venv/bin/activate

To generate a new Requirements of all the libraries
pip freeze > requirements.txt

If you don't have the requirements and want to install (after create and activate venv)
pip install -r requirements.txt

If your VsCode is in wrong interpreter, enter the path of a new interprter and put that:
Windows: backend\processing_server\.venv\Scripts\python.exe
Linux: backend/processing_server/.venv/bin/python