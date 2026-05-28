# Country Explorer

Country Explorer is a high-performance, scalable web application designed for seamless browsing of global data. The project emphasizes clean architecture, secure cloud infrastructure, and automated deployment lifecycles, demonstrating production-ready engineering practices.

**Live Site:** [http://13.228.75.74/](http://13.228.75.74/)  
**Repository:** [https://github.com/PathumSandeepa/country-explorer.git](https://github.com/PathumSandeepa/country-explorer.git)

---

## Table of Contents
- [System Architecture](#system-architecture)
- [Design Philosophy](#design-philosophy)
- [Resilience & API Strategy](#resilience--api-strategy)
- [Architectural Design Decisions & Roadmap](#architectural-design-decisions--roadmap)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Setup Instructions](#setup-instructions)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
- [Security & Access Control](#security--access-control)
- [Account Setup](#account-setup)
- [GitHub Actions CI/CD Pipeline](#github-actions-cicd-pipeline)
- [Troubleshooting](#troubleshooting)

---

## System Architecture

The application implements a strict separation of concerns, ensuring that the request lifecycle is predictable, testable, and maintainable.

```text
+----------------+      +----------------+      +------------------+
|                |      |                |      |                  |
|  Client (Web)  +----->+     Routes     +----->+    Controller    |
|                |      |  (Rate Limiter)|      |  (Input Val.)    |
+----------------+      +----------------+      +---------+--------+
                                                          |
                                                          v
                                                +---------+--------+
+----------------+      +----------------+      |                  |
|                |      |                |      |  Service Layer   |
| External API   +<-----+   API Client   +<-----+  (Business Logic)|
| (RestCountries)|      |  (w/ Fallback) |      |                  |
+----------------+      +----------------+      +---------+--------+
                                                          |
                                                          v
                                                +---------+--------+
+----------------+                              |                  |
|                |                              | Repository Layer |
|   PostgreSQL   +<-----------------------------+ (Data Access)    |
|                |                              |                  |
+----------------+                              +------------------+
```

## Design Philosophy

The core architectural pattern employed is the **Service-Repository Pattern**. This approach was deliberately chosen to:
*   **Decouple Business Logic:** Controllers remain lean, responsible solely for HTTP request handling and initial validation. Complex business rules and API interactions are encapsulated within the Service Layer.
*   **Abstract Data Access:** The Repository Layer provides a unified interface for data retrieval and persistence, shielding the application from direct database or ORM dependencies.
*   **Facilitate Unit Testing:** By decoupling dependencies, Services and Repositories can be mocked independently, enabling comprehensive, isolated testing of business rules without requiring a live database connection or framework-specific code.

## Resilience & API Strategy

Robust applications must gracefully handle external dependencies. The system integrates with the external RestCountries API while prioritizing stability:
*   **Graceful Fallback:** In the event that the external RestCountries API experiences downtime or high latency, the application is designed to degrade gracefully. It catches connection exceptions and either serves cached data or returns consistent localized error responses, preventing cascading failures across the application layer.
*   **Rate Limiting & Throttling:** Inbound API requests are strictly throttled (`throttle:15,1`) to prevent abuse and ensure equitable resource distribution.

## Architectural Design Decisions & Roadmap

This project was developed with a focus on rapid, robust delivery (MVP). Certain architectural decisions were made to prioritize stability and developer velocity over premature optimization:

*   **Monolithic Architecture:** While microservices are excellent for massive, distributed teams, a modular monolithic architecture was chosen here to ensure codebase consistency, simplified deployment pipelines, and lower operational overhead during the initial development phase.
*   **Storage-based Caching:** For the current scope, standard application-level caching is utilized. The architecture is ready to be swapped with **Redis** if the application requires horizontal scaling or shared state across multiple app instances in the future.
*   **Role-Based Access Control (RBAC):** The current scope focuses on user-centric productivity (individual favourites and notes). The design is fully compatible with an RBAC layer should the requirements evolve to include multi-tenant or administrative permissions.
*   **CI/CD Maturity:** The current CI/CD pipeline ensures automated testing and deployments. Future phases include integrating **Docker/Kubernetes** for environment parity and potentially migrating to a managed service like AWS Fargate for serverless scaling.

### Scalability Roadmap
Building upon the current architecture, the system is designed to evolve through the following strategic phases to handle increased scale:
*   **Phase 1: Managed Database (RDS):** Migrating from an on-instance PostgreSQL database to AWS RDS for high availability, automated backups, and multi-AZ redundancy.
*   **Phase 2: Horizontal Scaling:** Implementing an Application Load Balancer (ALB) to distribute traffic across an Auto Scaling Group of stateless EC2 instances.
*   **Phase 3: Distributed Caching (Redis):** Transitioning to a dedicated Redis cluster to manage shared sessions across instances and accelerate read-heavy operations.
*   **Phase 4: Container Orchestration:** Finalizing the migration to Docker and utilizing Kubernetes (Amazon EKS) or ECS for highly orchestrated, scalable deployments.

---

## Features
- **Global Data Browsing**: High-performance rendering of global country data.
- **Favorites Management**: Persistent storage of favorite countries, enriched with personal annotations.
- **Performance & Security**: Implements strict security headers (X-Frame-Options, STS), encrypted session management, and optimized asset caching.
- **Zero-Touch Deployment**: Fully automated CI/CD workflows utilizing GitHub Actions.

## Tech Stack
- **Backend:** PHP 8.5+, Laravel 13.x
- **Frontend:** Node.js 24+, Tailwind CSS, Alpine.js, Vite
- **Database:** PostgreSQL (Production/Local) / SQLite (Testing)
- **Infrastructure:** AWS EC2 (Ubuntu 24.04 LTS), Nginx, PHP-FPM
- **CI/CD:** GitHub Actions

## Project Structure
Adheres to standard Laravel conventions, heavily leaning on custom architectural layers:
- `app/Http/Controllers/` - HTTP request handling and parameter validation.
- `app/Services/` - Core business logic orchestration.
- `app/Repositories/` - Data access abstraction and ORM encapsulation.
- `routes/web.php` & `routes/auth.php` - Route definitions.
- `database/migrations/` & `database/seeders/` - Schema state management.

## Setup Instructions

### Prerequisites
- PHP >= 8.5
- Composer
- Node.js & npm (v24+ recommended)
- PostgreSQL (or Docker for containerized DB)

### Local Development Environment
1. **Clone the repository:**
   ```bash
   git clone https://github.com/PathumSandeepa/country-explorer.git
   cd country-explorer
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Update the `.env` file with your database credentials (e.g., `DB_CONNECTION=pgsql`).*
4. **Database Migration:**
   ```bash
   php artisan migrate
   ```
5. **Start Servers:**
   ```bash
   php artisan serve
   npm run dev
   ```

*Note: For a containerized PostgreSQL instance, use the following Docker command:*
```bash
docker run --name country-explorer-db -e POSTGRES_DB=laravel -e POSTGRES_USER=postgres -e POSTGRES_PASSWORD=secret -p 5432:5432 -d postgres:16
```

## Database Schema
The core application state is managed across the following primary entities:
- `users`: Core authentication entity.
- `favourite_countries`:
  - `user_id` (FK -> users.id)
  - `country_code` (String, Indexed)
  - `name`, `capital`, `flag_url`, `personal_note`
  - *Integrity Constraint:* Unique composite index on `['user_id', 'country_code']` ensures data consistency.

## API Endpoints
RESTful endpoints protected by `auth`, `verified`, and rate-limiting middleware:
- `GET /dashboard`: Main application interface.
- `POST /favourites`: Persist a new favorite.
- `PUT /favourites/{id}`: Mutate an existing favorite (e.g., updating notes).
- `DELETE /favourites/{id}`: Destroy a favorite record.
- `GET/PATCH/DELETE /profile`: User lifecycle management.

## Security & Access Control
Access boundaries are strictly enforced via Laravel's authentication guards:
- **Tenant Isolation:** The current implementation ensures users can only access and mutate their own data records.

## Account Setup
To ensure you have a working login immediately after setting up the project, you can insert a demo user directly into your PostgreSQL database. This bypasses the need for development-only seeding dependencies (like `faker`) in a production-like environment:

```sql
INSERT INTO users (name, email, password, created_at, updated_at) 
VALUES (
    'Demo User', 
    'demo@example.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    NOW(), 
    NOW()
);
```
*(Note: The provided hash corresponds to the password `password`)*

## GitHub Actions CI/CD Pipeline
The delivery pipeline is fully automated via GitHub Actions, emphasizing zero-downtime deployments and strict quality gates. The current pipeline performs automated linting and testing on every push before any deployment is triggered, highlighting our commitment to code quality and system stability.

### Pipeline Stages
1. **Environment Provisioning:** PHP 8.5 & Node 24+ setup.
2. **Dependency Resolution:** Composer & NPM install.
3. **Asset Compilation:** Production-ready minification via Vite (`npm run build`).
4. **Quality Assurance:** Laravel Pint (Code Style) and PHPUnit (Automated Tests via SQLite).

### Production Infrastructure
Deployed on **AWS EC2 (Ubuntu 24.04 LTS)**:
- **Compute:** Optimized t3 instance.
- **Networking:** Strict Security Groups (ports 80, 443, 22) and Elastic IP.
- **Reverse Proxy:** Nginx configured for gzip compression and strict security headers.
- **Automated Deployment:** SSH-based pull, dependency optimization, and graceful Nginx/PHP-FPM reloads.
  ```bash
  git pull origin main
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan optimize:clear
  sudo systemctl restart nginx
  ```

## Troubleshooting
- **Permission Denied (Storage/Cache):** The web server daemon requires write access:
  ```bash
  sudo chown -R www-data:www-data storage bootstrap/cache
  sudo chmod -R 775 storage bootstrap/cache
  ```
- **Database Connection Failures:** Validate `.env` variables and ensure the database daemon (or Docker container) is accepting connections on the specified port.
- **Production HTTP 500s:** Ensure `APP_DEBUG=false`. Execute `php artisan optimize:clear` to purge compiled configurations. Consult `storage/logs/laravel.log` for localized stack traces.
  > **Pro-tip:** In production environments, HTTP 500 errors immediately after deployment are frequently caused by incorrect directory permissions. Double-check that the `www-data` user owns the `storage` and `bootstrap/cache` directories.

