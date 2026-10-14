#!/usr/bin/env bash
# ==============================================================================
# Pulso Cívico — Runner Universal para Linux / Mac (Nativo o Contenedor Docker)
# Ejecuta gateway.php usando PHP local si existe, o contenedor php:8.2-cli.
# ==============================================================================
set -e

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$DIR"

ACTION="${1:-help}"
shift || true

if command -v php >/dev/null 2>&1; then
    exec php tools/gateway.php "$ACTION" "$@"
else
    exec docker run --rm --network host -u "$(id -u):$(id -g)" -v "$DIR:/app" -w /app php:8.2-cli php tools/gateway.php "$ACTION" "$@"
fi
