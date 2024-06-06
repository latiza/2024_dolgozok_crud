document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("form").addEventListener("submit", async function(event) {
        event.preventDefault();

        let nev = document.getElementById("nev").value;
        let mobil = document.getElementById("mobil").value;
        let email = document.getElementById("email").value;

        try {
            let response = await fetch("felvitelbackend.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ nev, mobil, email })
            });

            let result = await response.json();
                        console.log(result);
            if (response.ok) {
                if (result.success) {
                    window.location.href = "lista.php";
                } else {
                    document.getElementById("kimenet").innerHTML = result.errors.join("<br>");
                }
            } else {
                throw new Error("Hálózati hiba, a szerver nem válaszol");
            }
        } catch (error) {
            console.error("Error:", error);
            document.getElementById("kimenet").innerHTML = "Hiba történt az adatok feldolgozása közben.";
        }
    });
});
