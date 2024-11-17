
import subprocess
from flask import Flask, request, jsonify
import json

app = Flask(__name__)

def run_shell_script(script_path):

    # Uruchomienie skryptu przy pomocy subprocess
    try:
        result = subprocess.run(['bash', script_path], check=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
        print("Script output:")
        print(result.stdout)  # Wyświetlanie standardowego wyjścia
        if result.stderr:
            print("Script error output:")
            print(result.stderr)  # Wyświetlanie błędów
    except subprocess.CalledProcessError as e:
        print(f"An error occurred while running the script: {e}")
    except FileNotFoundError:
        print(f"Script not found: {script_path}")

@app.route('/')
def index():
    return '<h1>Hello from Python!</h1>'

@app.route('/postreceive', methods=['POST'])
def postreceive():
    script_path = '/home/admin/git-jga-script/jga-auto-pull.sh'
    run_shell_script(script_path)
    
    # Odczytanie danych z webhooka GitHub
    # payload = request.json
    
    # print(json.dumps(payload))

    # # Tutaj dodaj swoją akcję, np. wypisanie informacji o commicie
    # commit_message = payload['head_commit']['message']
    # pusher_name = payload['pusher']['name']

    # # Przykład: Wyświetlenie informacji o commicie
    # print(f"Commit received from {pusher_name}: {commit_message}")

    # # Możesz wykonać inne akcje, np. uruchomienie skryptu, aktualizowanie systemu itp.
    

    return jsonify({'status': 'success', 'message': 'Commit received!'}), 200

if __name__ == "__main__":
    # app.run(debug=False, port=5000)
    app.run(debug=False, host='127.0.0.1', port=5000)



# @app.route("/get-user-dishes-scores", methods=["POST"])
# def get_user_dishes_scores():
    # data = request.get_json()
    # login = data.get("login")
    
    # if not login:
    #     return jsonify({"error": "Wszystkie parametry są wymagane"}), 400
    
    # user_id = af.internal_get_user_id(login)

    # result, code = af.internal_get_user_dishes_scores(user_id)
    
    # return jsonify(result), code
