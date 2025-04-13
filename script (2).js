document.addEventListener("DOMContentLoaded", function () {
    const bgImage = document.querySelector(".overlay");
    const container = document.getElementById("container");
    let loginImage = true; // Track whether we are showing login or signup background

    function toggleForm() {
        // Fade out the background image before toggling the form
        bgImage.style.opacity = "0";

        // Wait for fade-out to complete (1.5s) before toggling form
        setTimeout(() => {
            container.classList.toggle("active"); // Toggle form display

            // Change background image when the form has just toggled
            if (loginImage) {
                bgImage.style.backgroundImage = "url('cbum2.png')";
            } else {
                bgImage.style.backgroundImage = "url('cbum.jpg')";
            }

            // Fade in the new background after swapping
            setTimeout(() => {
                bgImage.style.opacity = "1";
            }, 300); // Slight delay to sync with form movement

            loginImage = !loginImage; // Flip the state
        }, 750); // Halfway before transition ends
    }

    // Attach event listeners to sign-in and sign-up toggle links
    document.querySelectorAll(".link").forEach((link) => {
        link.addEventListener("click", toggleForm);
    });
});








// function fetchNutrition(food) {
//     let apiUrl = `https://api.api-ninjas.com/v1/nutrition?query=${encodeURIComponent(food)}`;

//     fetch(apiUrl, { headers: { 'X-Api-Key': API_KEY } })
//     .then(response => response.json())
//     .then(data => {
//         if (data.length > 0) {
//             let resultHTML = `<h3>Nutrition Facts for "${food}":</h3>`;
//             data.forEach(item => {
//                 resultHTML += `
//                     <p><strong>${item.name}</strong></p>
//                     <p>Calories: ${item.calories} kcal</p>
//                     <p>Protein: ${item.protein_g}g</p>
//                     <p>Fat: ${item.fat_total_g}g</p>
//                     <p>Carbs: ${item.carbohydrates_total_g}g</p>
//                     <hr>`;
//             });
//             document.getElementById('result').innerHTML = resultHTML;
//         } else {
//             document.getElementById('result').innerHTML = "<p>No nutrition data found for this item.</p>";
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         document.getElementById('result').innerHTML = '<p>Failed to fetch nutrition data.</p>';
//     });
// }



// else {
//     fetchNutrition(query);
// }