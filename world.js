window.onload = () => {
    const result = document.getElementById("result");

    document.getElementById('lookup').addEventListener('click', (event) => {
        event.preventDefault();

        let country = encodeURIComponent(document.getElementById('country').value.trim());
        console.log('country value', country);

        let url = 'http://localhost/info2180-lab5/world.php?country=' + country;
        console.log('url', url);

        fetch(url)
            .then(response => {
                if(response.ok) {
                    return response.text();
                }
            })
            .then(data => {
                result.innerHTML = data;
            })
    })
}
