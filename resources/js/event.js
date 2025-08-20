// Create an instance of Notyf
const notyf = new Notyf({
    duration: 1000,
    position: {
        x: 'right',
        y: 'top',
    },
    types: [
        {
            type: 'success',
            background: 'green',
            duration: 10000,
            dismissible: true
        },
        {
            type: 'warning',
            background: 'orange',
            icon: {
                className: 'material-icons',
                tagName: 'i',
                text: 'warning'
            },
            duration: 10000,
            dismissible: true
        },
        {
            type: 'error',
            background: 'indianred',
            duration: 10000,
            dismissible: true
        }
    ]
});




 
window.addEventListener('alert', (event) => {
    let data = event.detail;

    // Swal.fire({
    //     position: data.position || 'center',
    //     icon: data.type || 'info',
    //     title: data.title || 'Alert',
    //     showConfirmButton: false,
    //     timer: data.timer || 1500
    // });

    // if (data.type === "success") {
    //     // You can re-enable Notyf if needed
    //     notyf.success(data.title);
    // }

    // toastr.options = {
    //     closeButton: true,
    //     progressBar: true,
    //     timeOut: 5000,
    //     extendedTimeOut: 1000,
    //     positionClass: "toast-top-right",
    //     escapeHtml: false // IMPORTANT: allow HTML
    // };

    // toastr.options = {
    //     "closeButton": true,
    //     "debug": false,
    //     "newestOnTop": false,
    //     "progressBar": false,
    //     "positionClass": "toast-top-right",
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "300",
    //     "hideDuration": "1000",
    //     "timeOut": "5000",
    //     "extendedTimeOut": 1000,
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "hideMethod": "fadeOut",
    //     escapeHtml: false // IMPORTANT: allow HTML
    //   }
    
   

    if (data.type === "success") { 
        notyf.success(data.title); 
    } else if (data.type === "error") {
        notyf.success(data.title);
    }

    initFlowbite();
});




/** Pusher Events */

window.Echo.private("users")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('userCreated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('user create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }  


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);

        Livewire.dispatch('userUpdated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('user edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('userDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('user delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    });
     



window.Echo.private("activity_logs")
    .listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('logDeleted');
  
        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('activity log list delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 
         


        initFlowbite();
    });


window.Echo.private("roles")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('roleCreated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('role create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);

        Livewire.dispatch('roleUpdated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('role edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('roleDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('role delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.updated_permissions', (e) => {

        console.log(e.message);

        Livewire.dispatch('rolePermissionUpdated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('role add permission');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    });

window.Echo.private("permissions")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('permissionCreated');
        

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('permission create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 

        


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);

        Livewire.dispatch('permissionUpdated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('permission edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }  
         

        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('permissionDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('permission delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }  
        

        initFlowbite();
    });

window.Echo.private("funeral_schedules")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('funeralScheduleCreated');
 
        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 

        // ✅ Reload only on homepage
        if (window.location.pathname === '/' || window.location.pathname === '/dashboard') {
            window.location.reload();
        }

        

        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);


        
        Livewire.dispatch('funeralScheduleUpdated');
 
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }

        // // ✅ Reload only on homepage
        // if (window.location.pathname === '/' || window.location.pathname === '/dashboard') {
        //     window.location.reload();
        // }


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('funeralScheduleDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }  


        // ✅ Reload only on homepage
        if (window.location.pathname === '/' || window.location.pathname === '/dashboard') {
            window.location.reload();
        }

        initFlowbite();
    });

window.Echo.channel("funeral_schedules")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('funeralScheduleCreated');
 
        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule create');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // } 

        // ✅ Reload only on homepage
        if (window.location.pathname === '/' || window.location.pathname === '/dashboard') {
            window.location.reload();
        }

        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);


        
        Livewire.dispatch('funeralScheduleUpdated');
 
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule edit');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // }

        // notyf.success(e.message);


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('funeralScheduleDeleted');
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule delete');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // }  


        // ✅ Reload only on homepage
        if (window.location.pathname === '/' || window.location.pathname === '/dashboard') {
            window.location.reload();
        }

        initFlowbite();
    });



window.Echo.private("service_schedules")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('serviceScheduleCreated');
 
        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);


        
        Livewire.dispatch('serviceScheduleUpdated');
 
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }

        


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('serviceScheduleDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }  


        initFlowbite();
    });

window.Echo.channel("service_schedules")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('serviceScheduleCreated');
 
        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule create');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // } 


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);


        
        Livewire.dispatch('serviceScheduleUpdated');
 
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule edit');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // }

        


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('serviceScheduleDeleted');
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule delete');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // }  


        initFlowbite();
    });
 


window.Echo.private("hospice_schedules")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('hospiceScheduleCreated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('hospice schedule create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);

        Livewire.dispatch('hospiceScheduleUpdated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('hospice schedule edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('hospiceScheduleDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('hospice schedule delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }  


        initFlowbite();
    });


window.Echo.private("settings")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('settingCreated');
        
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('setting create');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);

        Livewire.dispatch('settingUpdated');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('setting edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('settingDeleted');
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('setting delete');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        } 


        initFlowbite();
    });


    
window.Echo.channel("settings")
    .listen('.created', (e) => {

        console.log(e.message);

        Livewire.dispatch('settingCreated');
        
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('setting create');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // } 


        initFlowbite();
    }).listen('.updated', (e) => {

        console.log(e.message);

        Livewire.dispatch('settingUpdated');
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('setting edit');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // } 


        initFlowbite();
    }).listen('.deleted', (e) => {

        console.log(e.message);

        Livewire.dispatch('settingDeleted');
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('setting delete');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // } 


        initFlowbite();
    });



window.Echo.channel("dashboard")
    .listen('.updated', (e) => {

        console.log(e.message);


        
        Livewire.dispatch('dashboardUpdated');
 
 

        // const hasRole = window.currentUser.roles.includes('Global Administrator');
        // const hasPermission = window.currentUser.permissions.includes('funeral schedule edit');


        // if (hasRole) {
        //     notyf.success(e.message); 
        // }else if(hasPermission){
        //     notyf.success(e.message); 
        // }

        


        initFlowbite();
    });

window.Echo.private("dashboard")
    .listen('.updated', (e) => {

        console.log(e.message);


        
        Livewire.dispatch('dashboardUpdated');
 
 

        const hasRole = window.currentUser.roles.includes('Global Administrator');
        const hasPermission = window.currentUser.permissions.includes('funeral schedule edit');


        if (hasRole) {
            notyf.success(e.message); 
        }else if(hasPermission){
            notyf.success(e.message); 
        }

        


        initFlowbite();
    });