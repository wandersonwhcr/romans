Vagrant.configure(2) do |config|
    config.vm.box = "puppetlabs/debian-8.2-32-puppet"

    config.vm.provision 'puppet' do |puppet|
        puppet.options          = "--verbose --debug"
        puppet.environment      = "develop"
        puppet.environment_path = "puppet/environments"
    end
end
