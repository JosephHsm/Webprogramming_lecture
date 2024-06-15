document.addEventListener('DOMContentLoaded', function () {
    const daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    daysOfWeek.forEach(day => {
        loadRoutines(day);
    });

    document.getElementById('reset-button').addEventListener('click', resetWeek);
});

function addRoutine(day) {
    const inputField = document.getElementById(`${day}-input`);
    const routineTitle = inputField.value.trim();

    if (routineTitle === '') {
        alert('Please enter a routine title.');
        return;
    }

    fetch('add_routine.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ day: day, text: routineTitle })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            appendRoutineToPage(day, { id: data.id, text: routineTitle, checked: false });
            inputField.value = '';
        } else {
            alert('Failed to add routine: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error adding routine:', error);
    });
}

function appendRoutineToPage(day, routine) {
    const routinesDiv = document.getElementById(`${day}-routines`);
    const routineDiv = document.createElement('div');
    routineDiv.classList.add('routine');
    routineDiv.innerHTML = `
        <input type="text" value="${routine.text}" readonly>
        <input type="checkbox" ${routine.checked ? 'checked' : ''} onchange="updateRoutine(${routine.id}, this.checked)">
        <button onclick="removeRoutine(${routine.id}, '${day}')">Remove</button>
    `;
    routinesDiv.appendChild(routineDiv);
}

function loadRoutines(day) {
    fetch(`get_routines.php?day=${day}`)
        .then(response => response.json())
        .then(data => {
            const routinesDiv = document.getElementById(`${day}-routines`);
            routinesDiv.innerHTML = '';
            data.forEach(routine => {
                appendRoutineToPage(day, routine);
            });
        })
        .catch(error => {
            console.error('Error loading routines:', error);
        });
}

function removeRoutine(id, day) {
    fetch('remove_routine.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadRoutines(day);
        } else {
            alert('Failed to remove routine: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error removing routine:', error);
    });
}

function resetWeek() {
    fetch('reset_routines.php', { method: 'POST' })
        .then(response => response.text())
        .then(result => {
            alert('All checkboxes have been unchecked!');
            const daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            daysOfWeek.forEach(day => {
                loadRoutines(day);
            });
        })
        .catch(error => {
            console.error('Error resetting week:', error);
        });
}

function updateRoutine(id, checked) {
    fetch('update_routine.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id, checked: checked })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to update routine: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error updating routine:', error);
    });
}

function updateProfile() {
    const height = document.getElementById('height').value;
    const weight = document.getElementById('weight').value;
    const body_fat = document.getElementById('body_fat').value;

    fetch('profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ height: height, weight: weight, body_fat: body_fat })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
        } else {
            alert('Failed to update profile.');
        }
    })
    .catch(error => {
        console.error('Error updating profile:', error);
    });
}