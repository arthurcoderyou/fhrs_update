// import './bootstrap';
// import 'flowbite';

import './bootstrap'; 
import '@tailwindplus/elements'; // registers <el-dropdown>, <el-menu>, etc.
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/js/all.min.js';
import 'flowbite';
import { initFlowbite } from 'flowbite';

// Listen for Livewire `navigate` events
document.addEventListener('livewire:navigated', () => {
    // Reinitialize Flowbite
    window.dispatchEvent(new Event('load'));

    initFlowbite();

});



 
Livewire.hook('message.processed', () => {
    initFlowbite();
});

 
import './echo';






import './event';



 

