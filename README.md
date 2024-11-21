<div align="center">
    <img src="https://i.imgur.com/WEPSHWd.png">
</div>

<p align="center">
    <img src="https://img.shields.io/github/license/dantsec/UrlShortenerAPI?color=black&logo=github&logoColor=white&style=for-the-badge">
    <img src="https://img.shields.io/github/issues/dantsec/UrlShortenerAPI?color=black&logo=github&logoColor=white&style=for-the-badge">
    <img src="https://img.shields.io/github/stars/dantsec/UrlShortenerAPI?color=black&label=STARS&logo=github&logoColor=white&style=for-the-badge">
    <img src="https://img.shields.io/github/forks/dantsec/UrlShortenerAPI?color=black&logo=github&logoColor=white&style=for-the-badge">
    <img src="https://img.shields.io/github/languages/code-size/dantsec/UrlShortenerAPI?color=black&logo=github&logoColor=white&style=for-the-badge">
</p>

<h1 align="center">
    Url Shortener API 🚀
</h1>

> **UrlShortenerAPI** is a project built to efficiently convert long URLs into shorter, easy-to-share links. It offers a reliable redirection service, allowing users to shorten URLs and retrieve detailed information about each shortened link. Key features include a simple API interface for creating and managing shortened URLs, flexible configuration options, and the ability to track shortened URL details. This API is ideal for applications that need to manage and share links while saving space and providing clean URLs.

## Authors 👥

- For more information see my blog and my contributions to community.
    - [**dantsec**](https://www.github.com/dantsec)

## Tech Stack 🧑‍💻

- This project was developed with the following technologies:
    - [**PHP**](https://www.php.net/) (Main Language)
    - [**Lumen**](https://lumen.laravel.com/) (Micro-Framework)
    - [**Composer**](https://getcomposer.org/) (Dependency Management)

## Documents 📂

- [**License**](./LICENSE)
- [**Draw**](./docs/url-shortener-api.excalidraw)

## Installation / Run Locally ⚙️

- **Important**: Ensure you have [**Composer**](https://getcomposer.org/) installed.

### Steps

1. **Clone the repository** and navigate into the project directory:

```bash
git clone https://github.com/yourusername/UrlShortenerAPI.git

cd UrlShortenerAPI/
```

2. **Install dependencies**:

```bash
composer install
```

3. **Create and edit your .env**:

```bash
cp .env.example .env && vi .env
```

4. **Run the server**:
    - The server will start on `http://localhost:9000`;
    - You can now access and use the API to shorten URLs and retrieve information.

```bash
php -S localhost:9000 -t public/
```

## Todo List 📌

- Priority (**1**)
    - [ ] Testes Unitarios;
    - [ ] Modularizar (igual na `scaff`)?
    - [ ] Melhorar tratamento de erros e responses;
    - [ ] Documentacao (Swagger).
- Priority (**2**)
    - [ ] Sistema de Logs;
    - [ ] Adicionar Paginacao & Filtragem;
    - [ ] Transformar Helpers em traits?
    - [ ] Middleware para `isExpired`?

## Contributing 🛠️

```bash
# Create a fork from the original repository and clone it.
git clone https://github.com/dantsec/UrlShortenerAPI.git
# Enter into the project folder.
cd UrlShortenerAPI/
# Create a new branch with the name feat-[BRANCH_NAME].
git checkout -b feat/[BRANCH_NAME]
# Make your changes and commit them.
git add . && git commit -m "YOUR_COMMIT_MESSAGE"
# Push your branch and open a pull request.
git push origin feat/[BRANCH_NAME]
```
