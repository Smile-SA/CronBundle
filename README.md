# SmileCronBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1b9063ff-aa66-4fd6-b1fc-08fbec3797a0/mini.png)](https://insight.sensiolabs.com/projects/1b9063ff-aa66-4fd6-b1fc-08fbec3797a0)

Cron Bundle scheduler

## Description

This bundle offer a command that you should use as a cronjob :

```cmd
* * * * * cd <your_project_root> && php app/console smile:cron
```

This command will list all commands extending "CronAbstract" class and defined as service tagged with "smile.cron".

You can define specific cron expression for each command as cron and prioritize them.

## Documentation

[Documentation](Resources/doc/README.md)

