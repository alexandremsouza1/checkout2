#!/bin/bash

echo "Starting Supervisor"
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf -n
```
