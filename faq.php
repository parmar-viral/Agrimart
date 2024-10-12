<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Footer</title>
    <?php include 'css.php';?>
    <style>
        

        .faq-section {
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }

        .faq-item {
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .faq-question {
            font-weight: bold;
            cursor: pointer;
            position: relative;
            padding-right: 20px;
        }

        .faq-question::after {
            content: "+";
            position: absolute;
            right: 0;
            top: 0;
            font-size: 20px;
        }

        .faq-answer {
            display: none;
            padding-top: 10px;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-question::after {
            content: "-";
        }
    </style>
</head>
<body>
<?php include 'menu.php';?>
    <!-- Footer with FAQ section -->
    <footer class="footer">
        <div class="faq-section">
            <div class="faq-item">
                <div class="faq-question">What is your return policy?</div>
                <div class="faq-answer">Our return policy lasts 30 days. If 30 days have gone by since your purchase, unfortunately, we can’t offer you a refund or exchange.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">How do I track my order?</div>
                <div class="faq-answer">Once your order has shipped, we will send you an email with a tracking number and a link to track your package.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">Do you offer international shipping?</div>
                <div class="faq-answer">Yes, we offer international shipping to many countries. Shipping rates will be calculated at checkout based on your location.</div>
            </div>
            <!-- Add more FAQ items as needed -->
        </div>
    </footer>

    <!-- JavaScript to toggle FAQ answers -->
    <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const faqItem = item.parentElement;
                faqItem.classList.toggle('active');
            });
        });
    </script>
    <?php include 'footer.php';?>
    <?php include 'js.php';?>
</body>
</html>
