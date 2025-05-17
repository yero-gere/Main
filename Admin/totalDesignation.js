document.addEventListener('DOMContentLoaded', function () {
    const totalDesignation = document.getElementById('totalDesignation');
    const searchBtn = document.getElementById('searchBtn');
    const searchWords = document.getElementById('searchWords');
    const desiBody = document.querySelector('.desiBody');
    const pagination = document.querySelector('.pagination');

    // Fetch total destinations and data
    function fetchDestinations(search = '') {
        fetch(`getDestinations.php?search=${search}`)
            .then(response => response.json())
            .then(data => {
                // Display the total number of destinations
                totalDesignation.textContent = data.total_destinations;

                // Display destinations in the table
                desiBody.innerHTML = ''; // Clear previous results
                data.destinations.forEach(destination => {
                    const div = document.createElement('div');
                    div.classList.add('destination');
                    div.innerHTML = `
                        <h3>${destination.name}</h3>
                        <p>Location: ${destination.location}</p>
                        <p>Price: $${destination.price}</p>
                    `;
                    desiBody.appendChild(div);
                });

                // Handle pagination here if needed (e.g., for large datasets)
                // Pagination logic would be added here if the dataset is paginated
            })
            .catch(err => console.error('Error fetching data:', err));
    }

    // Initially load destinations
    fetchDestinations();

    // Handle search
    searchBtn.addEventListener('click', function () {
        const searchTerm = searchWords.value;
        fetchDestinations(searchTerm);  // Fetch destinations based on search term
    });
});
