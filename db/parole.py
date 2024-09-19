with open('./660000_parole_italiane.txt', 'r') as f:
    words=f.read().splitlines()
    last=words[-1]
    parole=[a for a in words if len(a)==5]

print(parole)
print(len(parole))

#remove duplicates
parole=list(set(parole))

query='INSERT INTO word (word) VALUES '

for i,word in enumerate(parole):
    query+='("'+word+'")'
    if i<len(parole)-1:
        query+=',\n'
    else:
        query+=';'

with open('query.sql', 'w') as f:
    f.write(query)
