import {signaturePad, clearButton} from "./components/signaturePad";
import {myDropzone} from "./components/dropzone";


// Lorsque le canvas de signature est initialisé, désactiver la zone de drop
const disableDropZone = function() {
    signaturePad.addEventListener("beginStroke", () => {
        myDropzone.disable();
        document.querySelector('.signature-drop').classList.add('off')
    }, { once: true });
}

// Lorsque le canvas de signature est vidé, reactive la zone de drop
clearButton.addEventListener('click', function() {
    myDropzone.enable();
    document.querySelector('.signature-drop').classList.remove('off')
    disableDropZone()
});

disableDropZone();

// Lorsque le drop est un success :
myDropzone.on('success', function () {
    document.querySelector('.signature-hand').classList.add('off')
    // désactive la zone de drop
    myDropzone.disable();
    // désactive la signature manuelle
    signaturePad.off();
    // clear signature manuelle
    signaturePad.clear();
});

// Lorsque le fichier est supprimé de DropzoneJS, réactive la signature manuelle
myDropzone.on('removedfile', function () {
    if (myDropzone.files.length === 0) {
        document.querySelector('.signature-hand').classList.remove('off')
        signaturePad.on();
        myDropzone.enable();
    }
});