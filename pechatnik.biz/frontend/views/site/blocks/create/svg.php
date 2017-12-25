<svg id="svg1" xmlns="http://www.w3.org/2000/svg" style="width: 270px; height: 270px">
  <circle id="circle1" r="100" cx="135" cy="135" style="fill: white; stroke: blue; stroke-width: 2"></circle>
  <circle id="circle2" r="80" cx="135" cy="135" style="fill: white; stroke: blue; stroke-width: 2"></circle>
  <defs>
    <!-- The text path: see links above regarding coordinate system -->
    <path d=" M40, 135
    a95, 95 0 1, 0 190, 0
    a95, 95 0 1, 0 -190, 0"
    id="txt-path">
    </path>
  </defs>

  <text fill="blue" font-size="12" font-family="Arial" font-weight="600" textLength="590" style="letter-spacing: 3.6;">
    <!-- This is the magic -->
    <textPath startOffset="0" xlink:href="#txt-path">ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ * ПРИМЕР *</textPath>
  </text>
  <text id="t1" fill="blue" font-size="18" font-family="Arial" font-weight="600" x="135" y="140" text-anchor="middle"><?= $data['stamp_name'] ?></text>
</svg>
