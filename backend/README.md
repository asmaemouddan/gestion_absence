# SmartPresence

## Système Intelligent de Gestion des Présences par Reconnaissance Faciale

SmartPresence est une application web destinée à automatiser la gestion des présences des étudiants grâce à la reconnaissance faciale.

L’objectif est de faciliter le travail des enseignants et de l’administration, de réduire les erreurs de saisie manuelle et d’améliorer le suivi des présences.

---

## 🎯 Objectifs

* Automatiser l’enregistrement des présences.
* Identifier les étudiants à partir de leur visage.
* Réduire les erreurs liées à la saisie manuelle.
* Faciliter la gestion des étudiants, classes, modules et séances.
* Permettre aux enseignants de consulter et gérer les présences.
* Gérer les justifications d'absence.
* Centraliser les données dans une base de données MySQL.

---

## 🛠️ Technologies utilisées

### Backend

* Laravel
* PHP
* MySQL
* Laravel Artisan

### Reconnaissance faciale

* Python
* FastAPI
* OpenCV
* face_recognition
* NumPy
* Uvicorn

### Frontend

* Blade
* JavaScript
* Bootstrap
* Sass
* Vite

### Conteneurisation

* Docker
* Docker Compose

### Base de données

* MySQL 8.0
* phpMyAdmin

### Gestion du code

* Git
* GitHub

---

## 🏗️ Architecture

Le projet est organisé autour de plusieurs services Docker :

```text
                    SmartPresence
                         │
          ┌──────────────┼──────────────┐
          │              │              │
          ▼              ▼              ▼
      Laravel          MySQL       Face Service
        PHP             DB            Python
          │                              │
          │                              │
          └──────────────┬───────────────┘
                         │
                         ▼
                    Application Web
```

### Services Docker

| Service      | Technologie      |    Port |
| ------------ | ---------------- | ------: |
| app          | Laravel / PHP    |    8002 |
| node         | Node.js / Vite   | interne |
| db           | MySQL 8.0        |    3307 |
| phpmyadmin   | phpMyAdmin       |    8080 |
| face-service | Python / FastAPI |    8001 |

---

## 📁 Structure du projet

```text
gestion_absence/
│
├── backend/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── composer.json
│   ├── composer.lock
│   ├── package.json
│   ├── package-lock.json
│   ├── vite.config.js
│   ├── Dockerfile
│   └── .env.example
│
├── face-service/
│   ├── main.py
│   ├── requirements.txt
│   └── Dockerfile
│
├── docker-compose.yml
└── README.md
```

---

# 🚀 Installation

## 1. Cloner le projet

```bash
git clone https://github.com/asmaemouddan/gestion_absence.git
cd gestion_absence
```

---

## 2. Créer le fichier `.env`

Laravel utilise le fichier `.env` pour sa configuration.

```bash
cp backend/.env.example backend/.env
```

Configurer ensuite la base de données :

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=absence_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 3. Construire et démarrer Docker

```bash
docker compose up -d --build
```

Vérifier les services :

```bash
docker compose ps
```

---

## 4. Installer les dépendances Laravel

```bash
docker compose run --rm app composer install
```

---

## 5. Générer la clé Laravel

```bash
docker compose exec app php artisan key:generate
```

---

## 6. Préparer la base de données

```bash
docker compose exec app php artisan migrate
```

Si le projet utilise des données initiales :

```bash
docker compose exec app php artisan migrate --seed
```

---

## 7. Installer les dépendances Frontend

Le projet utilise un service Node.js indépendant pour gérer npm et Vite.

```bash
docker compose run --rm node npm ci
```

Construire les assets :

```bash
docker compose run --rm node npm run build
```

Le build génère notamment :

```text
backend/public/build/manifest.json
```

---

## 8. Nettoyer le cache Laravel

```bash
docker compose exec app php artisan optimize:clear
```

---

# ▶️ Lancer le projet

Si les services sont arrêtés :

```bash
docker compose up -d
```

Vérifier leur état :

```bash
docker compose ps
```

---

# 🌐 Accès aux services

### Application Laravel

```text
http://localhost:8002
```

### Face Recognition API

```text
http://localhost:8001
```

### phpMyAdmin

```text
http://localhost:8080
```

### MySQL

```text
Host: localhost
Port: 3307
```

À l'intérieur du réseau Docker, Laravel utilise :

```text
Host: db
Port: 3306
```

---

# 🤖 Reconnaissance faciale

Le service de reconnaissance faciale est développé avec Python et FastAPI.

Il permet notamment de :

* traiter les images des étudiants ;
* détecter les visages ;
* comparer les caractéristiques faciales ;
* identifier un étudiant ;
* retourner le résultat au backend Laravel.

Communication :

```text
Laravel
   │
   │ HTTP Request
   ▼
Face Service
   │
   ├── OpenCV
   ├── face_recognition
   └── NumPy
```

---

# 🗄️ Gestion des données

L'application utilise MySQL pour stocker les principales données du système :

* utilisateurs ;
* étudiants ;
* classes ;
* modules ;
* professeurs ;
* séances ;
* présences ;
* justifications.

Les migrations Laravel permettent de créer et gérer la structure de la base de données.

---

# 🔧 Commandes Docker utiles

### Voir les containers

```bash
docker compose ps
```

### Voir les logs

```bash
docker compose logs
```

### Logs Laravel

```bash
docker compose logs app
```

### Logs Face Service

```bash
docker compose logs face-service
```

### Logs Node

```bash
docker compose logs node
```

### Arrêter les services

```bash
docker compose down
```

### Redémarrer les services

```bash
docker compose restart
```

### Reconstruire les images

```bash
docker compose up -d --build
```

---

# 🧹 Réinitialisation du cache Laravel

En cas de problème après une modification de configuration :

```bash
docker compose exec app php artisan optimize:clear
```

---

# 👥 Équipe du projet

**Projet : SmartPresence**

Système intelligent de gestion des présences par reconnaissance faciale.

### Membres

* Laila Belaoula
* Asmae Mouddan

### Encadrement

**M. Mohamad Qassi**

---

# 📌 Contexte

SmartPresence a été réalisé dans le cadre d'un projet de développement digital avec pour objectif d'explorer l'intégration de l'intelligence artificielle et de la reconnaissance faciale dans une application web de gestion des présences.

Le projet combine le développement web, la gestion des bases de données, les services API et le traitement d'images.

---

# 📄 Licence

Ce projet est réalisé dans un cadre académique.
