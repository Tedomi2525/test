document.addEventListener('DOMContentLoaded', () => {
    // Hàm reload lại trang sau khi thay đổi giỏ hàng
    const reloadCart = () => location.reload();

    // Hàm hiển thị thông báo lỗi hoặc thành công
    const showAlert = (message, isError = false) => {
        alert(isError ? `Lỗi: ${message}` : message);
    };

    // Xử lý nút xóa sản phẩm khỏi giỏ hàng
    document.querySelectorAll('.cart_item-remove').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.id;
            if (!productId) {
                showAlert('ID sản phẩm không hợp lệ', true);
                return;
            }

            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                fetch(`/cart/remove/${productId}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('Xóa sản phẩm thành công');
                            reloadCart();
                        } else {
                            showAlert(data.message || 'Xóa sản phẩm thất bại', true);
                        }
                    })
                    .catch(error => showAlert('Có lỗi xảy ra khi xóa sản phẩm', true));
            }
        });
    });

    // Xử lý tăng số lượng sản phẩm
    document.querySelectorAll('.quantity-increase').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.id;
            if (!productId) {
                showAlert('ID sản phẩm không hợp lệ', true);
                return;
            }

            fetch(`/cart/increase/${productId}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reloadCart();
                    } else {
                        showAlert(data.message || 'Cập nhật thất bại', true);
                    }
                })
                .catch(error => showAlert('Có lỗi xảy ra khi cập nhật giỏ hàng', true));
        });
    });

    // Xử lý giảm số lượng sản phẩm
    document.querySelectorAll('.quantity-decrease').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.id;
            if (!productId) {
                showAlert('ID sản phẩm không hợp lệ', true);
                return;
            }

            fetch(`/cart/decrease/${productId}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reloadCart();
                    } else {
                        showAlert(data.message || 'Cập nhật thất bại', true);
                    }
                })
                .catch(error => showAlert('Có lỗi xảy ra khi cập nhật giỏ hàng', true));
        });
    });

    // Xử lý thêm sản phẩm vào giỏ hàng
    document.querySelectorAll('.product_list-addtocart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.id;
            const productName = button.dataset.name;
            const productPrice = button.dataset.price;

            if (!productId || !productName || !productPrice) {
                showAlert('Thông tin sản phẩm không hợp lệ.', true);
                return;
            }

            fetch('/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: productId, name: productName, price: parseFloat(productPrice) })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Thêm sản phẩm thành công');
                    } else {
                        showAlert(data.message || 'Thêm sản phẩm thất bại', true);
                    }
                })
                .catch(error => showAlert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ', true));
        });
    });
});
