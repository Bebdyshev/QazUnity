        function deleteMessage(messageId) {
            if (confirm("Вы уверены, что хотите удалить это сообщение?")) {
                fetch(`delete_message.php?message_id=${messageId}`, {
                    method: 'GET'
                })
                .then(response => {
                    if (response.ok) {
                        const messageElement = document.getElementById(`message_${messageId}`);
                        if (messageElement) {
                            messageElement.style.display = 'none';
                        }
                    } else {
                        alert('Ошибка удаления сообщения');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
            }
        }
