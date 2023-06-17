import SignaturePad from "signature_pad";
import "../styles/signaturePad.css"

const canvas = document.getElementById('signature-pad');
const saveButton = document.getElementById('save-button');
const clearButton = document.getElementById('clear-button');

const signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});


// Écouter l'événement de clic sur le bouton d'effacement pour vider la signature
clearButton.addEventListener('click', function() {
    signaturePad.clear();
});

// saveButton.addEventListener('click', function() {
//     const signatureData = signaturePad.toDataURL(); // Convertit la signature en données Base64
//     // Ici, vous pouvez envoyer les données Base64 à votre backend pour les enregistrer en base de données
//     console.log(signatureData); // Affiche les données Base64 dans la console (pour vérification)
// });
export {signaturePad, clearButton}