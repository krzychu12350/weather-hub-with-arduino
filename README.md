# Weather Hub With Arduino and ESP2866
![Logo](./public/logo.png)

## About Weather Hub
The progressive web application built with Laravel, Vue and OpenWeatherMap API

## Tech Stack
**Client**<br>

<img src="https://skillicons.dev/icons?i=html,css,bootstrap,vue,vite" /> 

**Server**<br>

<img src="https://skillicons.dev/icons?i=laravel,mysql" />


## Setup Locally

1. Clone the project

```bash
  git clone https://gitlab.ideo.pl/k.karas/weather-hub.git
```

2. Go to the project directory

```bash
  cd weahter-hub
```

3. Install dependencies

```bash
  composer install
```

```bash
  npm install
```

4. Copy the file '.env.example' and rename it to '.env', then configure it
to allow application connect with database


5. Run migrations and seeders

```bash
  php artisan migrate --seed
```

6. Generate keys

```bash
  php artisan key:generate
```

```bash
  php artisan jwt:secret
```

7. Start the Laravel server

```bash
  php artisan serve
```

8. Start the Laravel schedule worker

```bash
  php artisan schedule:work
```

9. Start the Vite server

```bash
  npm run dev
```

## Features
- Cross-platform
- Search For Place 🔍
- Create an account
- Delete user account
- Manage primary place
- Manage favourite places
- Real Time Weather Data 🌄
- Check Daily and Hourly Forecast
- Switch between temperature unit measurements
- Check out historical temperature and humidity chart for favorite places


## Screenshots

<img src="./readme/images/sign-in.jpg"  alt="sign-in-view"/>

<img src="./readme/images/sign-up.jpg"  alt="sign-up-view"/>

<img src="./readme/images/home-1.jpg"  alt="home-1"/>

<img src="./readme/images/home-dynamic-background.jpg"  alt="home-dynamic-background"/>

<img src="./readme/images/home-search-engine.jpg"  alt="home-search-engine"/>

<img src="./readme/images/home-2.jpg"  alt="home-2"/>

<img src="./readme/images/home-hourly-chart.jpg"  alt="home-hourly-chart"/>

<img src="./readme/images/home-historical-temp-and-hum-chart.jpg"  alt="home-historical-temp-and-hum-chart"/>

<img src="./readme/images/favourite-places.jpg"  alt="favourite-places"/>

<img src="./readme/images/add-favourite-place.jpg"  alt="add-favourite-place"/>

<img src="./readme/images/settings-page.jpg"  alt="settings-page"/>

<img src="./readme/images/tablet-rwd-1.jpg"  alt="tablet-rwd-1"/>

<img src="./readme/images/tablet-rwd-2.jpg"  alt="tablet-rwd-2"/>

<img src="./readme/images/smartphone-rwd-1.jpg"  alt="smartphone-rwd-1"/>

<img src="./readme/images/smartphone-rwd-2.jpg"  alt="smartphone-rwd-2"/>

<img src="./readme/images/start-pwa.jpg"  alt="start-pwa.jpg"/>

<img src="./readme/images/pwa.jpg"  alt="pwa.jpg"/>


## Users already existing in the database

• Tom Cruise<br>
Email Address: ```t.cruise@gmail.com```<br>
Password: ```tcruise12?3```<br>

• Adam Lambert<br>
Email Address: ```a.lambert@gmail.com```<br>
Password: ```alambert12?3```<br>
