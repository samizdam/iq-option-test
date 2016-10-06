# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.box_check_update = false
  config.vm.synced_folder ".", "/vagrant", type: "nfs"
  config.vm.provision "install", type: "shell", path: "./common/scripts/install-all.sh"
  config.vm.provision "run", type: "shell", path: "./common/scripts/docker/run.sh"
end
