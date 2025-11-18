# script para intalar todas las extensiones y sus versiones automaticamente
# desde powershell en windows o usando bash en linux

# si la extension ya estaba instalada pero era otra version diferente se instalara
# la version listada en este script.



# ejecuta el script para asegurarnos de que todos tenemos las mismas versiones

#Uso:
    # Desde powershell ejecutar: ./estearchivo.sh


code --install-extension  ms-vsliveshare.vsliveshare@1.0.5959 --force
code --install-extension  xdebug.php-debug@1.37.0 --force
code --install-extension  ms-azuretools.vscode-containers@2.2.0 --force
code --install-extension  bmewburn.vscode-intelephense-client@1.14.4 --force
