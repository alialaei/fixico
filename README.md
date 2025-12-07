# Feature Flag Service – Full Stack Assignment

This project is a simple feature flag system with:

- Laravel as the Admin panel and API  
- Next.js + React + TanStack Query as the client application  

It demonstrates:
- Managing feature flags from an admin panel
- Advanced feature rollouts (time-based + conditional segmentation)
- A client application that consumes flags and conditionally enables UI and features
- Backend enforcement of feature availability

---

## Project Structure

/
  backend/    → Laravel application (Admin + API)
  frontend/   → Next.js application (Client)

---

## 1. Backend (Laravel + Docker)

### Requirements
- Docker
- Docker Compose

### Setup

cd backend
docker compose build  
docker compose up -d  

Backend URL:

http://localhost:8000  

Admin feature flags panel:

http://localhost:8000/admin/feature-flags  

---

## 2. Frontend (Next.js + pnpm + TanStack Query)

### Requirements
- Node.js 18+
- pnpm

### Setup

cd frontend  
pnpm install
cp .env.example .env  
pnpm dev  

Frontend URL:

http://localhost:3000  

---

## 3. Feature Flags Overview

Each feature flag supports:

- enable and disable
- Scheduled activation
  - starts_at
  - ends_at
- Conditional segmentation
  - Example: enable only for specific countries via conditions

Example of stored conditions:

{
  "country": ["NL", "DE"]
}


---

## 4. Conditionally Available Features (Business Logic)

The following actions are fully gated by feature flags on both frontend and backend:

1. Create report  
   - Frontend: form hidden or disabled if flag is off  
   - Backend: API guarded by feature middleware  

2. Edit report  
   - Frontend: form fields disabled if flag is off  
   - Backend: API guarded by feature middleware  

2. Delete report  
   - Frontend: form fields disabled if flag is off  
   - Backend: API guarded by feature middleware  

2. Show Report
   - Frontend: form fields disabled if flag is off  
   - Backend: API guarded by feature middleware  

If a feature is disabled while the user is interacting with the UI, the backend responds with:

403 Forbidden  

and the client handles the state gracefully.

---

## 5. Caching Strategy

- Feature flag evaluations are cached to reduce database load
- Cache is invalidated automatically when a flag is updated
- The client uses TanStack Query for request caching and synchronization

---

## 6. Logging (Optional Bonus)

All feature flag evaluations are logged for debugging and monitoring purposes.

---

## 7. Notes

- This implementation does not use any third-party feature flag packages.
- All feature evaluation logic is custom-built.
- The system demonstrates:
  - Progressive rollout
  - Safe feature delivery
  - Frontend and backend consistency

