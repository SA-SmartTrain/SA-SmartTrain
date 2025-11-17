<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Perguntas Frequentes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #ffffff;
            color: #111827;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header com H1 e botões de acessibilidade */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 32px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .accessibility-buttons {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .accessibility-buttons button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            color: #4b5563;
            transition: color 0.3s ease;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .accessibility-buttons button:hover {
            color: #111827;
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 48px 32px;
            overflow-y: auto;
            padding-bottom: 100px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .faq-header h2 {
            font-size: 48px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        /* FAQ Items */
        .faq-list {
            border-top: 1px solid #e5e7eb;
        }

        .faq-item {
            border-bottom: 1px solid #e5e7eb;
        }

        .faq-button {
            width: 100%;
            padding: 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background-color 0.2s ease;
        }

        .faq-button:hover {
            background-color: #f9fafb;
        }

        .faq-question {
            font-size: 18px;
            font-weight: 500;
            color: #111827;
            flex: 1;
            padding-right: 16px;
        }

        .faq-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .faq-icon svg {
            width: 100%;
            height: 100%;
            stroke: #4b5563;
            stroke-width: 2;
        }

        .faq-item.expanded .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            color: #4b5563;
            line-height: 1.6;
            font-size: 16px;
        }

        .faq-item.expanded .faq-answer {
            max-height: 500px;
            padding-bottom: 24px;
        }

        /* Bottom Navigation Bar */
        .bottom-navbar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding-bottom: 16px;
        }

        .navbar-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #4b5563;
        }

        .navbar-item:hover {
            color: #111827;
        }

        .navbar-item.active {
            color: #111827;
        }

        .navbar-icon {
            font-size: 24px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-label {
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 16px;
            }

            header h1 {
                font-size: 20px;
            }

            .accessibility-buttons {
                gap: 12px;
            }

            .accessibility-buttons button {
                font-size: 20px;
                padding: 4px;
            }

            main {
                padding: 24px 16px;
                padding-bottom: 100px;
            }

            .faq-header h2 {
                font-size: 32px;
                margin-bottom: 32px;
            }

            .faq-button {
                padding: 16px 0;
            }

            .faq-question {
                font-size: 16px;
            }

            .bottom-navbar {
                height: 70px;
                padding-bottom: 8px;
            }

            .navbar-item {
                gap: 4px;
            }

            .navbar-icon {
                font-size: 20px;
            }

            .navbar-label {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header com H1 e Botões de Acessibilidade -->
    <header>

        <div class="accessibility-buttons">
            <button id="notifications-btn" title="Notificações">
                🔔
            </button>
            <button id="theme-btn" title="Alternar tema">
                🌙
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="faq-header">
                <h2>Still have questions? We got you.</h2>
            </div>

            <div class="faq-list" id="faqList">
                <!-- FAQ items will be inserted here by JavaScript -->
            </div>
        </div>
    </main>

    <!-- Bottom Navigation Bar -->
    

    <script>
        const faqData = [
            {
                id: 1,
                question: "What happens when I first join as an advisor?",
                answer: "When you join as an advisor, you'll get access to our platform with all the tools and resources you need to manage your clients and bookings. You'll receive onboarding support and training materials to help you get started quickly."
            },
            {
                id: 2,
                question: "I am already a professional travel advisor. Can I join Fora?",
                answer: "Yes, absolutely! We welcome experienced travel advisors. Our platform is designed to support professionals at all levels. Simply complete our application process, and our team will review your credentials and experience."
            },
            {
                id: 3,
                question: "What types of travel can I book as a Fora Advisor?",
                answer: "As a Fora Advisor, you can book a wide range of travel services including flights, hotels, vacation packages, cruises, tours, and customized travel experiences. Our platform supports bookings for leisure, business, and adventure travel."
            },
            {
                id: 4,
                question: "What is Fora's commission split?",
                answer: "Our commission structure is competitive and transparent. The exact split depends on your tier level and booking volume. We offer tiered commission rates that increase as you grow your business with us."
            },
            {
                id: 5,
                question: "How much does Fora's advisor subscription plan cost and are there any fees beyond this?",
                answer: "Our subscription plans are designed to be affordable and scalable. Pricing varies based on the features and support level you choose. We're transparent about all costs—there are no hidden fees beyond your subscription."
            },
            {
                id: 6,
                question: "Are there minimum bookings or sales quotas?",
                answer: "We believe in supporting our advisors without imposing strict quotas. While we encourage active participation, there are no mandatory minimum sales requirements. We focus on helping you succeed at your own pace."
            },
            {
                id: 7,
                question: "Do I need an LLC to join Fora?",
                answer: "No, you don't necessarily need an LLC to join Fora. We work with independent contractors, sole proprietors, and business entities. Our team can discuss the best structure for your situation during the application process."
            }
        ];

        // Render FAQ items
        function renderFAQ() {
            const faqList = document.getElementById('faqList');
            
            faqData.forEach(item => {
                const faqItem = document.createElement('div');
                faqItem.className = 'faq-item';
                faqItem.innerHTML = `
                    <button class="faq-button" onclick="toggleFAQ(this)">
                        <span class="faq-question">${item.question}</span>
                        <div class="faq-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer">${item.answer}</div>
                `;
                faqList.appendChild(faqItem);
            });
        }

        // Toggle FAQ item
        function toggleFAQ(button) {
            const faqItem = button.closest('.faq-item');
            faqItem.classList.toggle('expanded');
        }

        // Botão de notificações
        document.getElementById('notifications-btn').addEventListener('click', function() {
            alert('Você tem 3 novas notificações!');
        });

        // Botão de tema
        document.getElementById('theme-btn').addEventListener('click', function() {
            document.body.style.backgroundColor = document.body.style.backgroundColor === 'rgb(17, 24, 39)' ? '#ffffff' : '#111827';
            document.body.style.color = document.body.style.color === 'rgb(255, 255, 255)' ? '#111827' : '#ffffff';
        });

        // Navbar items
        document.querySelectorAll('.navbar-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.navbar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', renderFAQ);
    </script>
</body>
</html>
