

document.addEventListener("DOMContentLoaded", function() {
    
    
    const alerts = document.querySelectorAll('.alert');
    
    if (alerts.length > 0) {
        
        const delay = 4000; 
        
        setTimeout(function() {
            alerts.forEach(function(alert) {
                
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                
                
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, delay); 
    }

    const deleteLinks = document.querySelectorAll('a[href*="remover"], a[href*="apagar"], .btn-danger');

    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
        
            const confirmed = confirm("Tem certeza que deseja remover este item? Esta ação é irreversível.");
            
            if (!confirmed) {
                event.preventDefault(); 
            }
        });
    });

    
    const formRegistro = document.querySelector('form[action*="registro_process.php"]');
    
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const senhaInput = document.getElementById('senha');
            
            if (senhaInput && senhaInput.value.length < 6) {
                alert("A senha precisa ter pelo menos 6 caracteres!");
                event.preventDefault(); 
            }
        });
    }

});