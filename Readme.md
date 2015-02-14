# Freshwork Console Utility

Do you work with Laravel & Homestead? That package is for you

### Install
You need to install homestead 2.0 before usign this package.
```sh
composer global require "laravel/homestead=~2.0"
```
Now you can install freshwork/console
```sh
composer global require freshwork/console
```

### Usage
##### Configuration
```sh
freshwork init # Create your configuration file
#And then...
freshwork edit # Opens your configuration file so you can edit it.
```
Configuration file:
```json
{
	"projects_folder":"~/code", #Local projects folder
	"ssh_connection_cmd":"ssh vagrant@127.0.0.1 -p 2222", # SSH command to connect to homestead
	"homestead_code_directory":"/home/vagrant/code",# Homestead projects folder
	"homestead_ip":"192.168.10.10", # Ip of homestead VM
	"hosts_file":"/private/etc/hosts"
}
```

```sh
#Run this to check available commands
freshwork
#or
freshwork list
```

##### New project
You can install a new laravel project.
```sh
freshwork project:new client_name.project_name
```
```sh
freshwork project:new client_name/project_name
```
##### Default behavior
From the name 'client_name.project_name' we set default a configuration from your project (you can edit them by the command options).

This will install your project folder to:
- your/projects/folder/client_name/project_name
- Nginx site folder: your/projects/folder/client_name/project_name/public


Set your development domain to:
- project_name.app #So you can access your project through http://project_name.app in your local machine.

And then, it will install Laravel in the created directory.

```sh
# This will set your project domain as other_domain.local instead of project_name.app
freshwork project:new client_name.project_name -d 'other_domain.local'
```

Run this to check available options
```sh
freshwork project:new -h
```

##### Serve project
```sh
# Just the same as project:new, but doesn't create the directory nor install Laravel
freshwork project:new client_name.project_name
```

