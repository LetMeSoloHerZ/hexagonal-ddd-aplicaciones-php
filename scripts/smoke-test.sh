#!/usr/bin/env bash
# ============================================================
# Prueba de humo del CRUD de Aplicaciones (login + crear/ver/editar/eliminar).
#   BASE_URL=http://localhost:8081/public/index.php ./scripts/smoke-test.sh
# Variables: BASE_URL, ADMIN_EMAIL, ADMIN_PASSWORD, EXPECT_SEED (aplicacion de
# ejemplo que debe existir; vacia para omitir esa comprobacion).
# ============================================================
set -u

BASE_URL="${BASE_URL:-http://127.0.0.1:8080/public/index.php}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@crud.com}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-admin123}"
EXPECT_SEED="${EXPECT_SEED-Visual Studio Code}"

JAR="$(mktemp)"
trap 'rm -f "$JAR"' EXIT
FAILS=0
NAME="Smoke $(date +%s)"

ok()   { echo "  ok    $1"; }
fail() { echo "  FALLO $1"; FAILS=$((FAILS + 1)); }

req() { # req METODO ruta [curl args...]  -> imprime el cuerpo; guarda estado y Location
    local method="$1" route="$2"; shift 2
    curl -s -o /tmp/smoke_body -D /tmp/smoke_head -b "$JAR" -c "$JAR" -X "$method" "$@" "$BASE_URL?route=$route"
    STATUS="$(head -n1 /tmp/smoke_head | awk '{print $2}')"
    LOCATION="$(grep -i '^location:' /tmp/smoke_head | tr -d '\r' | sed 's/^[Ll]ocation: *//')"
}

check_redirect() { # check_redirect "descripcion" fragmento
    if [ "$STATUS" = "302" ] && [[ "$LOCATION" == *"$2"* ]]; then ok "$1"; else fail "$1 (status=$STATUS location=$LOCATION)"; fi
}

echo "Probando $BASE_URL"

req GET aplicaciones.index
check_redirect "sin sesion redirige al login" "route=auth.login"

req POST auth.authenticate --data-urlencode "email=$ADMIN_EMAIL" --data-urlencode "password=$ADMIN_PASSWORD"
check_redirect "login del administrador" "route=home"

req GET aplicaciones.index
if [ "$STATUS" = "200" ]; then ok "lista de aplicaciones (200)"; else fail "lista de aplicaciones (status=$STATUS)"; fi
if [ -n "$EXPECT_SEED" ]; then
    if grep -q "$EXPECT_SEED" /tmp/smoke_body; then ok "datos de ejemplo presentes ($EXPECT_SEED)"; else fail "falta la aplicacion de ejemplo $EXPECT_SEED"; fi
fi

req POST aplicaciones.store \
    --data-urlencode "nombre=$NAME" --data-urlencode "proveedor=ACME" --data-urlencode "categoria=DESARROLLO" \
    --data-urlencode "lenguajePrincipal=PHP" --data-urlencode "numBits=64" --data-urlencode "sistemaOperativo=LINUX" \
    --data-urlencode "licencia=COMERCIAL" --data-urlencode "precio=9.99" --data-urlencode "correo=smoke@acme.test" \
    --data-urlencode "tamanoInstalador=10"
check_redirect "crear aplicacion" "route=aplicaciones.index"

req GET aplicaciones.index
ID="$(NAME="$NAME" perl -0777 -ne 'print $1 if /\Q$ENV{NAME}\E<\/td>.*?show&amp;id=([0-9a-f-]{36})/s' /tmp/smoke_body)"
if [ -n "$ID" ]; then ok "la aplicacion aparece en la lista (id $ID)"; else fail "no se encontro la aplicacion creada"; fi

req GET aplicaciones.show --get --data-urlencode "id=$ID"
if [ "$STATUS" = "200" ] && grep -q "$NAME" /tmp/smoke_body; then ok "detalle de la aplicacion"; else fail "detalle (status=$STATUS)"; fi

req POST aplicaciones.update \
    --data-urlencode "id=$ID" --data-urlencode "nombre=$NAME" --data-urlencode "proveedor=ACME Labs" --data-urlencode "categoria=JUEGOS" \
    --data-urlencode "lenguajePrincipal=Java" --data-urlencode "numBits=32" --data-urlencode "sistemaOperativo=WINDOWS" \
    --data-urlencode "licencia=FREEMIUM" --data-urlencode "precio=0" --data-urlencode "correo=smoke@acme.test" \
    --data-urlencode "tamanoInstalador=5"
check_redirect "actualizar aplicacion" "route=aplicaciones.index"

req GET aplicaciones.show --get --data-urlencode "id=$ID"
if grep -q "ACME Labs" /tmp/smoke_body; then ok "la actualizacion se guardo"; else fail "la actualizacion no se refleja"; fi

req POST aplicaciones.delete --data-urlencode "id=$ID"
check_redirect "eliminar aplicacion" "route=aplicaciones.index"

req GET aplicaciones.index
if grep -q "$NAME" /tmp/smoke_body; then fail "la aplicacion sigue en la lista"; else ok "la aplicacion ya no aparece"; fi

echo
if [ "$FAILS" -eq 0 ]; then echo "PRUEBA DE HUMO: todo correcto"; exit 0; fi
echo "PRUEBA DE HUMO: $FAILS fallo(s)"; exit 1
