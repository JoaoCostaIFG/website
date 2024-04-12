#!/bin/sh

echo "IMPORTANT: Don't forget to run 'npm run dev'"
echo "IMPORTANT: The address if http://localhost:8000"

docker compose -f docker-compose.yml -f development.yml up --build
