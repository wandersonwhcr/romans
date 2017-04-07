Exec {
    path    => ["/usr/bin", "/bin", "/usr/sbin", "/sbin"],
    timeout => 0,
}

Package {
    require => Exec["apt-get : update"],
    before  => Exec["apt-get : autoremove"],
}

exec { "apt-get : update":
    command => "apt-get update",
}

exec { "apt-get : autoremove":
    command => "apt-get autoremove -q -y",
}

exec { "apt-get : https-update":
    command => "apt-get update",
}

package { "apt-get : https":
    name    => "apt-transport-https",
    require => Exec["apt-get : https-update"],
}

package { "vim":
    name => "vim",
}

package { "git":
    name => "git",
}

package { "unzip":
    name => "unzip",
}
