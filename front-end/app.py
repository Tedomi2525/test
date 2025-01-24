# app.py
from flask import Flask, render_template, request, jsonify, session

app = Flask(__name__)

# Biến lưu trữ giỏ hàng tạm thời (sử dụng session)
app.secret_key = 'your_secret_key'  # Thay thế 'your_secret_key' bằng chuỗi bí mật của bạn

def get_cart():
    if 'cart' not in session:
        session['cart'] = []
    return session['cart']

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/index')
def index():
    return render_template('index.html')

@app.route('/introduce')
def introduce():
    return render_template('introduce.html')

@app.route('/products')
def products():
    return render_template('products.html')

@app.route('/contact')
def contact():
    return render_template('contact.html')

@app.route('/cart')
def cart_view():
    cart = get_cart()
    total_price = sum(item['quantity'] * item.get('price', 0) for item in cart)
    return render_template('cart.html', cart=cart, total_price=total_price)

@app.route('/products/<int:product_id>')
def product(product_id):
    if 1 <= product_id <= 12:
        return render_template(f'product{product_id}.html')
    else:
        return "Sản phẩm không tồn tại", 404

# API: Thêm sản phẩm vào giỏ hàng
@app.route('/cart/add', methods=['POST'])
def add_to_cart():
    data = request.get_json()
    product_id = data.get('id')
    product_name = data.get('name')
    product_price = data.get('price', 0)

    if not product_id or not product_name:
        return jsonify(success=False, message="Dữ liệu không hợp lệ"), 400

    cart = get_cart()

    for item in cart:
        if item['id'] == product_id:
            item['quantity'] += 1
            session.modified = True
            return jsonify(success=True)

    cart.append({'id': product_id, 'name': product_name, 'price': product_price, 'quantity': 1})
    session.modified = True
    return jsonify(success=True)

# API: Xóa sản phẩm khỏi giỏ hàng
@app.route('/cart/remove/<int:product_id>', methods=['POST'])
def remove_from_cart(product_id):
    cart = get_cart()
    cart = [item for item in cart if item['id'] != product_id]
    session['cart'] = cart
    session.modified = True
    return jsonify(success=True)

# API: Tăng số lượng sản phẩm
@app.route('/cart/increase/<int:product_id>', methods=['POST'])
def increase_quantity(product_id):
    cart = get_cart()

    for item in cart:
        if [item for item in cart if item['id'] == product_id]:
            item['quantity'] += 1
            session.modified = True
            return jsonify(success=True)

    return jsonify(success=False, message="Sản phẩm không có trong giỏ hàng")

# API: Giảm số lượng sản phẩm
@app.route('/cart/decrease/<int:product_id>', methods=['POST'])
def decrease_quantity(product_id):
    cart = get_cart()

    for item in cart:
        if [item for item in cart if item['id'] == product_id]:
            if item['quantity'] >= 1:
                item['quantity'] -= 1
            else:
                cart.remove(item)
            session.modified = True
            return jsonify(success=True)

    return jsonify(success=False, message="Sản phẩm không có trong giỏ hàng")

if __name__ == '__main__':
    app.run(debug=True)
