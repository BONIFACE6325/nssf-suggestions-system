<form id="chatForm">
    <textarea name="message" id="message" placeholder="Ask AI..." required></textarea>
    <button type="submit">Send</button>
</form>

<div id="chatResponse"></div>

<script>
document.getElementById('chatForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const message = document.getElementById('message').value;

    let response = await fetch("{{ route('ai.chat') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message })
    });

    let data = await response.json();
    document.getElementById('chatResponse').innerText = data.message ?? data.error;
});
</script>
