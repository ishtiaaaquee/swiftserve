-- ============================================
-- SwiftServe Sample Data
-- Insert realistic Bangladesh food delivery data
-- ============================================

USE swiftserve;

-- ============================================
-- RESTAURANT CATEGORIES
-- ============================================

INSERT INTO restaurant_categories (name, slug, icon, display_order) VALUES
('Fast Food', 'fast-food', 'fa-burger', 1),
('Pizza', 'pizza', 'fa-pizza-slice', 2),
('Chinese', 'chinese', 'fa-bowl-rice', 3),
('Indian', 'indian', 'fa-pepper-hot', 4),
('Bengali', 'bengali', 'fa-fish', 5),
('Desserts', 'desserts', 'fa-ice-cream', 6),
('Beverages', 'beverages', 'fa-mug-hot', 7),
('Healthy', 'healthy', 'fa-leaf', 8);

-- ============================================
-- RESTAURANTS
-- ============================================

INSERT INTO restaurants (name, slug, cuisine_types, description, logo, cover_image, rating, delivery_time_min, delivery_time_max, min_order_amount, delivery_fee, address, area, is_featured, is_open) VALUES
('Burger King', 'burger-king', '["Fast Food", "American"]', 'Home of the Whopper. Flame-grilled burgers and more.', 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=200', 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?w=800', 4.5, 20, 30, 200, 30, 'Gulshan Circle 1, Dhaka', 'Gulshan', 1, 1),
('Pizza Hut', 'pizza-hut', '["Pizza", "Italian"]', 'Fresh pizzas with unlimited toppings and sides.', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=200', 'https://images.unsplash.com/photo-1571407970349-bc81e7e96a47?w=800', 4.3, 25, 35, 300, 40, 'Banani Road 11, Dhaka', 'Banani', 1, 1),
('KFC Bangladesh', 'kfc-bangladesh', '["Fast Food", "Chicken"]', 'Its finger lickin good! Fried chicken and more.', 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=200', 'https://images.unsplash.com/photo-1562059392-096320bccc7e?w=800', 4.4, 15, 25, 250, 35, 'Dhanmondi 27, Dhaka', 'Dhanmondi', 1, 1),
('Nandos', 'nandos', '["Grilled", "Portuguese"]', 'Legendary flame-grilled PERi-PERi chicken.', 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=200', 'https://images.unsplash.com/photo-1633237308525-cd587cf71926?w=800', 4.6, 20, 30, 400, 50, 'Gulshan 2, Dhaka', 'Gulshan', 1, 1),
('Chinese Wok', 'chinese-wok', '["Chinese", "Asian"]', 'Authentic Chinese cuisine with modern twist.', 'https://images.unsplash.com/photo-1526318472351-c75fcf070305?w=200', 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=800', 4.2, 25, 35, 300, 40, 'Mirpur DOHS, Dhaka', 'Mirpur', 0, 1),
('Khazana Restaurant', 'khazana', '["Indian", "Mughlai"]', 'Royal Indian cuisine and biriyani specialist.', 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=200', 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=800', 4.7, 30, 45, 350, 45, 'Uttara Sector 7, Dhaka', 'Uttara', 1, 1),
('Star Kabab & Restaurant', 'star-kabab', '["Bengali", "BBQ"]', 'Traditional Bengali food and grilled items.', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=200', 'https://images.unsplash.com/photo-1629451824260-d8d87c30e5cb?w=800', 4.1, 25, 35, 200, 30, 'Mohakhali DOHS, Dhaka', 'Mohakhali', 0, 1),
('Sweetalicious', 'sweetalicious', '["Desserts", "Bakery"]', 'Cakes, pastries and sweet delights.', 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=200', 'https://images.unsplash.com/photo-1587241321921-91a834d82ffc?w=800', 4.5, 20, 30, 150, 25, 'Bashundhara R/A, Dhaka', 'Bashundhara', 0, 1);

-- ============================================
-- MENU CATEGORIES
-- ============================================

INSERT INTO menu_categories (restaurant_id, name, display_order) VALUES
(1, 'Burgers', 1), (1, 'Sides', 2), (1, 'Beverages', 3),
(2, 'Pizzas', 1), (2, 'Pasta', 2), (2, 'Wings', 3),
(3, 'Chicken', 1), (3, 'Burgers', 2), (3, 'Combos', 3),
(4, 'PERi-PERi Chicken', 1), (4, 'Burgers', 2), (4, 'Sides', 3),
(5, 'Main Course', 1), (5, 'Rice & Noodles', 2), (5, 'Appetizers', 3),
(6, 'Biriyani', 1), (6, 'Curry', 2), (6, 'Tandoor', 3),
(7, 'BBQ', 1), (7, 'Bengali Dishes', 2), (7, 'Rice', 3),
(8, 'Cakes', 1), (8, 'Pastries', 2), (8, 'Ice Cream', 3);

-- ============================================
-- MENU ITEMS
-- ============================================

-- Burger King Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(1, 1, 'Whopper', 'Flame-grilled beef patty with fresh vegetables', 350, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400', 1, 1),
(1, 1, 'Chicken Royale', 'Crispy chicken fillet with mayo and lettuce', 320, 'https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400', 1, 1),
(1, 1, 'Double Cheese Burger', 'Two beef patties with double cheese', 420, 'https://images.unsplash.com/photo-1572802419224-296b0aeee0d9?w=400', 0, 1),
(1, 2, 'French Fries', 'Crispy golden fries', 120, 'https://images.unsplash.com/photo-1576107232684-1279f390859f?w=400', 1, 1),
(1, 2, 'Onion Rings', 'Crunchy battered onion rings', 150, 'https://images.unsplash.com/photo-1639024471283-03518883512d?w=400', 0, 1);

-- Pizza Hut Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(2, 4, 'Chicken Supreme', 'Chicken, mushroom, peppers, onions', 650, 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400', 1, 1),
(2, 4, 'Pepperoni Pizza', 'Classic pepperoni with extra cheese', 600, 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=400', 1, 1),
(2, 4, 'Veggie Paradise', 'Mixed vegetables with herbs', 550, 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=400', 0, 1),
(2, 5, 'Creamy Alfredo Pasta', 'Fettuccine in white cream sauce', 380, 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400', 0, 1);

-- KFC Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(3, 7, 'Zinger Burger', 'Spicy crispy chicken burger', 340, 'https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400', 1, 1),
(3, 7, '8 Piece Chicken Bucket', 'Mix of drumsticks and wings', 980, 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=400', 1, 1),
(3, 8, 'Mighty Zinger Meal', 'Zinger burger with fries and drink', 480, 'https://images.unsplash.com/photo-1619221882237-ce72a5e49da7?w=400', 1, 1);

-- Nandos Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(4, 10, 'Quarter Chicken', 'Flame-grilled with PERi-PERi sauce', 450, 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=400', 1, 1),
(4, 10, 'Half Chicken', 'Juicy grilled half chicken', 750, 'https://images.unsplash.com/photo-1633237308525-cd587cf71926?w=400', 1, 1),
(4, 11, 'Peri-Peri Chicken Burger', 'Spicy grilled chicken burger', 420, 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=400', 0, 1);

-- Chinese Wok Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(5, 13, 'Chicken Fried Rice', 'Classic fried rice with chicken', 280, 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400', 1, 1),
(5, 13, 'Hakka Noodles', 'Stir-fried noodles with vegetables', 250, 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=400', 1, 1),
(5, 14, 'Sweet & Sour Chicken', 'Crispy chicken in tangy sauce', 380, 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400', 0, 1);

-- Khazana Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(6, 16, 'Mutton Biryani', 'Aromatic mutton biriyani with raita', 480, 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=400', 1, 1),
(6, 16, 'Chicken Biryani', 'Classic chicken biriyani', 350, 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=400', 1, 1),
(6, 17, 'Butter Chicken', 'Creamy tomato curry with chicken', 420, 'https://images.unsplash.com/photo-1603894584373-5ac82b2ae398?w=400', 1, 1);

-- Star Kabab Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(7, 19, 'Mixed Grill Platter', 'Beef, chicken and fish kabab', 550, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=400', 1, 1),
(7, 20, 'Kacchi Biriyani', 'Traditional Bangladeshi biriyani', 380, 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=400', 1, 1);

-- Sweetalicious Menu
INSERT INTO menu_items (restaurant_id, menu_category_id, name, description, price, image, is_popular, is_available) VALUES
(8, 22, 'Chocolate Cake', 'Rich chocolate layer cake', 320, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400', 1, 1),
(8, 22, 'Red Velvet Cake', 'Classic red velvet with cream cheese', 350, 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=400', 1, 1),
(8, 23, 'Vanilla Ice Cream', 'Premium vanilla ice cream', 180, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400', 0, 1);

-- ============================================
-- PAYMENT PARTNERS
-- ============================================

INSERT INTO payment_partners (name, type, logo, display_order, is_active, has_offers, offer_text, cashback_percentage, max_cashback) VALUES
('Visa', 'card_network', 'https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg', 1, 1, 1, '10% cashback on weekends', 10, 200),
('Mastercard', 'card_network', 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg', 2, 1, 1, '5% cashback', 5, 150),
('bKash', 'mobile_banking', 'https://seeklogo.com/images/B/bkash-logo-7E6B252B9F-seeklogo.com.png', 3, 1, 1, '15% cashback up to ৳100', 15, 100),
('Nagad', 'mobile_banking', 'https://seeklogo.com/images/N/nagad-logo-7A70F4952D-seeklogo.com.png', 4, 1, 1, '10% cashback', 10, 80),
('Rocket', 'mobile_banking', 'https://seeklogo.com/images/D/dutch-bangla-rocket-logo-B4D1CC458D-seeklogo.com.png', 5, 1, 0, NULL, 0, 0),
('DBBL', 'bank', 'https://seeklogo.com/images/D/dutch-bangla-bank-limited-logo-4D268365B6-seeklogo.com.png', 6, 1, 1, 'Flat ৳50 off on orders above ৳500', 0, 50),
('Brac Bank', 'bank', 'https://seeklogo.com/images/B/brac-bank-logo-8F8E275F67-seeklogo.com.png', 7, 1, 0, NULL, 0, 0),
('City Bank', 'bank', 'https://seeklogo.com/images/C/city-bank-logo-D5AE73B5E9-seeklogo.com.png', 8, 1, 1, '5% discount', 5, 100);

-- ============================================
-- DEALS & OFFERS
-- ============================================

INSERT INTO deals_and_offers (restaurant_id, title, description, code, discount_type, discount_value, min_order_amount, max_discount, usage_limit, valid_from, valid_until, is_active) VALUES
(1, 'Whopper Wednesday', 'Get 20% off on all Whoppers', 'WHOPPER20', 'percentage', 20, 300, 150, 1000, '2025-12-01', '2025-12-31', 1),
(2, 'Pizza Party Deal', 'Buy 1 Large Pizza Get 1 Free', 'PIZZA2FOR1', 'percentage', 50, 500, 500, 500, '2025-12-01', '2025-12-31', 1),
(3, 'Bucket Bonanza', 'Flat ৳100 off on chicken buckets', 'BUCKET100', 'fixed', 100, 800, 100, 200, '2025-12-01', '2025-12-31', 1),
(NULL, 'First Order Special', 'Get 30% off on your first order', 'FIRST30', 'percentage', 30, 200, 200, NULL, '2025-12-01', '2026-12-31', 1),
(NULL, 'Weekend Feast', 'Flat ৳150 off on orders above ৳1000', 'WEEKEND150', 'fixed', 150, 1000, 150, NULL, '2025-12-01', '2025-12-31', 1);

-- ============================================
-- FAQS
-- ============================================

INSERT INTO faqs (category, question, answer, display_order, is_active) VALUES
('Orders', 'How do I place an order?', 'Browse restaurants, add items to cart, and proceed to checkout. Enter your delivery address and payment method to complete your order.', 1, 1),
('Orders', 'Can I modify my order after placing it?', 'You can modify your order within 2 minutes of placing it by contacting customer support.', 2, 1),
('Delivery', 'What are the delivery charges?', 'Delivery charges vary by restaurant and location, typically ranging from ৳30-৳50. Free delivery on orders above ৳500.', 1, 1),
('Delivery', 'How long does delivery take?', 'Delivery usually takes 20-45 minutes depending on restaurant preparation time and traffic.', 2, 1),
('Payment', 'What payment methods do you accept?', 'We accept Cash on Delivery, bKash, Nagad, Rocket, and all major credit/debit cards.', 1, 1),
('Payment', 'Is online payment secure?', 'Yes, all online payments are processed through secure payment gateways with encryption.', 2, 1);

-- ============================================
-- LOYALTY TIERS
-- ============================================

INSERT INTO loyalty_tiers (name, min_points, benefits, badge_image, color) VALUES
('Bronze', 0, '["1 point per ৳100 spent", "Birthday discount"]', NULL, '#CD7F32'),
('Silver', 500, '["1.5 points per ৳100 spent", "Free delivery once a month", "Birthday discount"]', NULL, '#C0C0C0'),
('Gold', 1500, '["2 points per ৳100 spent", "Free delivery twice a month", "Priority support", "Special offers"]', NULL, '#FFD700'),
('Platinum', 3000, '["3 points per ৳100 spent", "Unlimited free delivery", "VIP support", "Exclusive deals"]', NULL, '#E5E4E2');

-- ============================================
-- END OF SEED DATA
-- ============================================
