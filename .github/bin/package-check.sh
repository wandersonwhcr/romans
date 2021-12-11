#!/usr/bin/env sh

PATTERNS=$(cat <<EOF
composer.json
composer.lock
LICENSE
README.md
src/**.php
EOF
)

EXIT=0

for FILENAME in `zipinfo -1 build/package.zip`; do
    FOUND=0
    for PATTERN in $PATTERNS; do
        case $FILENAME in
            $PATTERN)
                FOUND=1
                ;;
        esac
    done
    if [ $FOUND -eq 0 ]; then
        echo $FILENAME 1>&2
        EXIT=1
    fi
done

exit $EXIT
