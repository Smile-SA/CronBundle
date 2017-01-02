# SmileCronBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1b9063ff-aa66-4fd6-b1fc-08fbec3797a0/mini.png)](https://insight.sensiolabs.com/projects/1b9063ff-aa66-4fd6-b1fc-08fbec3797a0)

Cron Bundle scheduler

## Description

This bundle offer a command that you should use as a cronjob :

```cmd
* * * * * cd <your_project_root> && php app/console smile:crons:run
```

This command will list all commands extending "CronAbstract" class and defined as service tagged with "smile.cron".

You can define specific cron expression for each command as cron and prioritize them.

## Documentation

[Documentation](Resources/doc/README.md)

## Changelog

### 1.0.1 -> 1.0.3

* update composer dependencies
* update docs

### 1.0.0 -> 1.0.1

* cron commands are now queued : add specific entity to register
when cron commands are queued, started and ended. Prevent multiple
cron command call while not ended.
* change smile:cron command to smile:crons:run command
* add smile:crons:status command
