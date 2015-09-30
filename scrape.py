#!/usr/bin/python
import re
import urllib2
from bs4 import BeautifulSoup as bs, SoupStrainer
import sys
from pprint import pprint
from urlparse import urlparse

def crawl(url, num, done_list, crawl_list, email_list, filt):
	ul = urlparse(url)
	base_url = ul.scheme + '://' + ul.netloc
	# base case
	if num <= 0:
		return email_list
	done_list.append(url)
	req = urllib2.Request(url, headers={ 'User-Agent': "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36" })
	try:
		page = urllib2.urlopen(req).read()
	except: 
		crawl(crawl_list.pop(0), num, done_list, crawl_list, email_list, filt)
		return
	soup = bs(page)
	emails = re.findall('\w+@\w+\.\w{2,3}(\.\w{2})?',str(soup))
	numbers = re.findall('[@\s][69]\d{3}[-\s]?\d{4}[\s\.]',str(soup))
	for email in emails:
		if email not in email_list and not email.endswith(('png','jpg')):
			email_list.append(email)
			print email
	for number in numbers:
		number = re.sub('[^0-9]','',number)
		if number not in email_list:
			email_list.append(number)
			print number
	ban = ['Login','login','css']
	for link in soup.find_all('a'):		
		try:
			link = link['href']
			if 'http' in link and not any(x in link for x in ban):
				if link not in done_list and link not in crawl_list and filt in link:
					crawl_list.append(link)
			elif 'css' not in link and not any(x in link for x in ban):
				if link.startswith('//'):
					link = 'http://' + link
				elif link.startswith('/'):
					link = base_url + link 	
					if link not in done_list and link not in crawl_list:
						if filt in link:
							crawl_list.append(link)
		except:
			pass
	num -= 1
	if crawl_list:
		try:
			crawl(crawl_list.pop(0), num, done_list, crawl_list, email_list, filt)
		except:
			crawl(crawl_list.pop(0), num, done_list, crawl_list, email_list, filt)
		return email_list
	else:
		pprint(done_list)
		return email_list

# Root url
url =  sys.argv[1]
pages = sys.argv[2]
# Append http protocol if missing
if 'http' not in url:
	url = 'http://' + url
# In case no filter argument is given
try:
	filt = sys.argv[3]
except:
	filt = '.'
# Run main
crawl(url,int(pages),[],[],[], filt)
