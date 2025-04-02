<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Niti Timeline – Horizontal View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
        }

        .niti-header {
            background-color: #c64058;
            color: white;
            padding: 25px 15px;
            text-align: center;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
        }

        .niti-header h2 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .niti-header p {
            font-size: 14px;
            color: #ffdce6;
        }

        .call-btn {
            margin-top: 10px;
            background: white;
            color: #c64058;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
        }

        .timeline-section {
            position: relative;
            padding: 40px 15px;
        }

        .timeline-scroll-container {
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .timeline-scroll-container::-webkit-scrollbar {
            display: none;
        }

        .timeline-row {
            display: flex;
            gap: 40px;
            position: relative;
            margin-top: 50px;
        }

        .timeline-row::before {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            height: 3px;
            background: #ddd;
            z-index: 0;
        }

        .timeline-box {
            flex: 0 0 240px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            padding: 16px;
            position: relative;
            text-align: center;
            border-top: 5px solid #ccc;
            z-index: 1;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .timeline-box::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid white;
            background-color: #ccc;
            z-index: 2;
        }

        .timeline-box.completed {
            border-top-color: #6f42c1;
        }

        .timeline-box.completed::before {
            background-color: #6f42c1;
        }

        .timeline-box.pending {
            border-top-color: #ffc107;
            opacity: 0.7;
        }

        .timeline-box.pending::before {
            background-color: #ffc107;
        }

        .timeline-box.running {
            border-top-color: #28a745;
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(40, 167, 69, 0.5);
            z-index: 2;
        }

        .timeline-box.running::before {
            background-color: #28a745;
        }

        .timeline-box h4 {
            font-size: 16px;
            color: #c64058;
            margin-bottom: 5px;
        }

        .timeline-box .time {
            font-size: 14px;
            color: #555;
        }

        .badge {
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .badge.completed {
            background-color: #e9d8fd;
            color: #6f42c1;
        }

        .badge.running {
            background-color: #d4edda;
            color: #28a745;
        }

        .badge.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .timeline-footer {
            text-align: center;
            font-size: 13px;
            color: #aaa;
            margin: 30px 0;
        }

        .nav-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .nav-buttons button {
            background: #c64058;
            color: white;
            border: none;
            padding: 8px 14px;
            margin: 0 10px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .nav-buttons button:hover {
            background: #a83246;
        }

        @media (max-width: 600px) {
            .timeline-box {
                flex: 0 0 200px;
            }
        }
    </style>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <div class="niti-header">
        <h2>Complete List Of Niti's</h2>
        <p>Rituals & their importance – live updates</p>
        <a href="tel:+91XXXXXXXXXX" class="call-btn">Call To Know →</a>
    </div>

    <div class="timeline-section">
        <div class="nav-buttons">
            <button onclick="scrollTimeline(-1)">← Prev</button>
            <button onclick="scrollTimeline(1)">Next →</button>
        </div>

        <div class="timeline-scroll-container" id="timelineScroll">
            <div class="timeline-row" id="timelineRow"></div>
        </div>
    </div>

    <div class="timeline-footer">
        © {{ date('Y') }} Temple Niti System. All rights reserved.
    </div>

    <script>
        const nitis = @json($nitis);

        function renderHorizontalTimeline() {
            const container = document.getElementById("timelineRow");
            container.innerHTML = '';

            const now = new Date();

            nitis.forEach((niti, i) => {
                const current = new Date(niti.date_time);
                const next = nitis[i + 1] ? new Date(nitis[i + 1].date_time) : null;

                let status = 'pending';
                if (current <= now && (!next || now < next)) {
                    status = 'running';
                } else if (current < now) {
                    status = 'completed';
                }

                const timeFormatted = current.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const endText = (status === 'running' && next)
                    ? `<p style="font-size: 13px; color: #777;">Ends by ${next.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>`
                    : '';

                container.innerHTML += `
                    <div class="timeline-box ${status}">
                        <div class="time">
                            <ion-icon name="time-outline" style="vertical-align: middle;"></ion-icon>
                            ${timeFormatted}
                        </div>
                        <h4>${niti.niti_name}</h4>
                        <span class="badge ${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>
                        ${endText}
                    </div>
                `;
            });
        }

        function scrollTimeline(direction) {
            const container = document.getElementById("timelineScroll");
            const boxWidth = 280; // approx width of timeline-box + gap
            container.scrollBy({
                left: direction * boxWidth,
                behavior: 'smooth'
            });
        }

        renderHorizontalTimeline();
        setInterval(renderHorizontalTimeline, 60000);
    </script>

</body>
</html>
