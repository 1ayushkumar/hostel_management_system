import zlib

def encode(text):
    """PlantUML uses a custom encoding for its online server."""
    compressed = zlib.compress(text.encode('utf-8'))[2:-4]
    return ''.join(chr((b >> 4) + 33) + chr((b & 0xF) + 33) for b in compressed)

# Read the PlantUML file
with open('er_diagram.puml', 'r') as f:
    content = f.read()

# Generate the URL
encoded = encode(content)
url = f"http://www.plantuml.com/plantuml/png/{encoded}"

print("\nYour ER diagram is available at:")
print(url)
