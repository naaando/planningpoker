[![codecov](https://codecov.io/gh/naaando/planningpoker/graph/badge.svg?style=for-the-badge&token=C8CL93UT7V)](https://codecov.io/gh/naaando/planningpoker)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?logo=tailwind-css&logoColor=white)
![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?logo=vuedotjs&logoColor=%234FC08D)

# Planning Poker Project with Laravel, Vue, Inertia.js, and Ably

## Overview

This is a Planning Poker project developed using Laravel as the backend framework, Vue.js for the frontend, Inertia.js for the middle layer, and Ably for real-time communication.


## Usage

![First time](/resources/images/first-time.png)
![Playing](/resources/images/playing.png)

## Technologies Used

- Laravel
- Vue.js
- Inertia.js
- Ably

## Requirements

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Database (e.g., MySQL)

## Installation

1. Clone the repository:

```
git clone https://github.com/naaando/planningpoker.git
```

2. Copy the environment file:

```
cp .env.example .env
```

3. Configure the environment file:

Open the `.env` file at the root of the project and configure your environment variables, including the database configuration and Ably credentials.

4. Start the project with Sail:

```
./vendor/bin/sail up -d
```

5. Install PHP dependencies:

```
./vendor/bin/sail composer install
```

6. Generate the application key:

```
./vendor/bin/sail artisan key:generate
```

7. Run database migrations:

```
./vendor/bin/sail artisan migrate
```

8. Install Node.js dependencies:

```
./vendor/bin/sail npm install
```

9. Compile assets:

```
./vendor/bin/sail npm run dev
```

## Contributing

Contributions are welcome! Please follow the instructions in [CONTRIBUTING.md](CONTRIBUTING.md).

## License

This project is licensed under the [MIT License](LICENSE).
