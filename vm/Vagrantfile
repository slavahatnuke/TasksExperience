require 'yaml'

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  project = YAML.load_file('Vagrantfile.project.yml')

  ## Box
  config.vm.box = project["box"]
  config.vm.box_url = project["box_url"]
  config.vm.guest = project["guest"]

  ## Network
  if project['ip']
      config.vm.network :private_network, ip: project['ip']
  end

  ## Network/Ports
  project["ports"].each do |key, value|
    config.vm.network :forwarded_port, guest: Integer(key), host: Integer(value)
  end

  ## Sync
  project["sync"].each do |key, value|
    config.vm.synced_folder key, value, :nfs => project["nfs"]
  end

  ## Provision
  project["provision"].each do |key, value|
    config.vm.provision "shell", inline: value
  end

  ## Properties
  config.vm.provider :virtualbox do |vb|

    vb.gui = project['gui']
    vb.name = project['project']

    vb.customize ["modifyvm", :id, "--memory", project['memory']]
    vb.customize ["modifyvm", :id, "--cpus", project['cpus']]

    vb.customize ["modifyvm", :id, "--acpi", project['acpi']]
    vb.customize ["modifyvm", :id, "--ioapic", project['ioapic']]
    vb.customize ["modifyvm", :id, "--vram", project['vram']]

    if project['nonrotational']
      vb.customize ["storageattach", :id, "--storagectl", "SATA Controller", '--port', '0', '--nonrotational', 'on']
    end

  end

end