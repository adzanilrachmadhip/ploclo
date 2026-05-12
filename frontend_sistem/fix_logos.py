import sys

with open('index.html', 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
skip = False
for line in lines:
    if "<!-- Logos -->" in line:
        skip = True
        continue
    if skip and "</div>" in line:
        skip = False
        continue
    if skip:
        continue
    new_lines.append(line)

content = "".join(new_lines)

target_insert = '<div class="container mx-auto px-4 h-screen flex flex-col md:flex-row items-center justify-center gap-12 z-10 relative">'
insertion = '''    <!-- Logos - Absolute Top Left -->
    <div class="absolute top-8 left-8 flex items-center gap-4 z-[100]">
        <img src="./assets/logo_prodi.png" alt="Logo Sistem Informasi" class="h-16 w-auto object-contain bg-white rounded-md p-1 shadow-lg">
        <img src="./assets/logo_telu.png" alt="Logo Telkom University Surabaya" class="h-16 w-auto object-contain bg-white rounded-md p-1 shadow-lg">
    </div>\n\n'''

content = content.replace(target_insert, insertion + target_insert)

with open('index.html', 'w', encoding='utf-8') as f:
    f.write(content)
