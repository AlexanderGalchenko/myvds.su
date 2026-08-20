#!/usr/bin/env bash
set -Eeuo pipefail

usage() {
  echo "Usage: $0 [--dry-run]"
}

DRY_RUN=0
case "${1:-}" in
  "") ;;
  --dry-run) DRY_RUN=1 ;;
  -h|--help) usage; exit 0 ;;
  *) usage >&2; exit 2 ;;
esac

SCRIPT_PATH="$(readlink -f -- "${BASH_SOURCE[0]}")"
REPO_DIR="$(cd -- "$(dirname -- "$SCRIPT_PATH")/.." && pwd)"
WEBROOT="${MYVDS_WEBROOT:-/docker/web-gw/www/html}"
SITE_DIR="$WEBROOT/myvds.su"
BACKUP_ROOT="$WEBROOT/backup "
BRANCH="${MYVDS_BRANCH:-main}"

command -v git >/dev/null
command -v rsync >/dev/null
test -d "$REPO_DIR/.git"
test -f "$REPO_DIR/index.php"
test -f "$REPO_DIR/send.php"

git -C "$REPO_DIR" fetch --prune origin
git -C "$REPO_DIR" checkout "$BRANCH"
git -C "$REPO_DIR" pull --ff-only origin "$BRANCH"

RSYNC_ARGS=(
  -a
  --delete
  --exclude=.git/
  --exclude=.github/
  --exclude=deploy/
  --exclude=README.md
  --exclude=.gitignore
  --exclude=storage/
)

if (( DRY_RUN )); then
  echo "Dry run: $REPO_DIR/ -> $SITE_DIR/"
  rsync -n "${RSYNC_ARGS[@]}" "$REPO_DIR/" "$SITE_DIR/"
  exit 0
fi

STAMP="$(date +%Y%m%d-%H%M%S)"
BACKUP_DIR="$BACKUP_ROOT/myvds.su-$STAMP"
mkdir -p "$BACKUP_ROOT"

if [[ -d "$SITE_DIR" ]]; then
  cp -a "$SITE_DIR" "$BACKUP_DIR"
  echo "Backup: $BACKUP_DIR"
else
  mkdir -p "$SITE_DIR"
fi

rsync "${RSYNC_ARGS[@]}" "$REPO_DIR/" "$SITE_DIR/"

echo "Deployed commit: $(git -C "$REPO_DIR" rev-parse --short HEAD)"
echo "Site directory: $SITE_DIR"
