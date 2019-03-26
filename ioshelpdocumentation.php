<html>
    <head>
        <title>
        </title>
        <link href="assets\style.css" rel="stylesheet" type="text/css" /></head>
    <body bgcolor="#E6E6FA">
        <center>
            
            <div id="summary-contant">
               <h3><i><center>"Food Delivery for multiple restaurant with delivery boy IPhone application Documentation by "FreakTemplate""</i></h3>
            	<h1><center>Food Delivery for multiple restaurant with delivery boy IPhone application</h1> </div>
            </div>                
            
			<div id="summary-contant">
				<p class="prepend-top">
					<h3>Contact Information</h3>
					<p>Email : <strong>freaktemplate@gmail.com</strong></p>
					<p>Skype : <strong>freaktemplate</strong><br /><br />Whatsapp : <strong>+918200438788</strong></p>
					<p>Thank you for purchasing this template, stay in touch and you can get benifits :</p>
					<p>1. you can contact us if you have any trouble while setup template.</p>
					<p>2. in future you can get update news&nbsp;</p>
					<p>3. If you require any customisation</p>
					<p>4. We also sell few products which is not available on code canyon,</p>
				</p>
			</div>
	
			<div id="summary-contant">
				<p>This Document will cover the following topics.</p>
				<h2 id="toc" class="alt">Table of Contents</h2>
		<ol class="alpha">
			<li><a href="#PurchasedPackageContents">Purchased Package Contents</a></li>
			<li><a href="#GettingStartedWithIOSApp">How to import IOS Project ?</a></li>
			<li><a href="#ChangetheURLofData">Change Backend URL </a></li>
			<li><a href="#ShoHideAds">Show Hide Admob Advertisement</a></li>
			<li><a href="#AdmobIntergration">Admob Integration : Change Admob ID</a></li>
			<li><a href="#ChangeBundleIdentifier">Change Package Name</a></li>
			<li><a href="#HowtoReskinApplication">How to Reskin Application</li>
			<li><a href="#LocalizeApp">Translate App in your language</a></li>
			<li><a href="#setupadmin">Setup Admin Panel (backend)</a></li>
			<li><a href="#facebooklogin">How to setup Facebook Login ?</a></li>							
			<li><a href="#setupgooglelogin">How to setup Google Login ?</a></li>							
			<li><a href="#howtocreatepushcertificate">How to create push certificate ?</a></li>							
			<li><a href="#setupfirebase">How to setup firebase ?</a></li>							
		</ol>
			</div>
		
		<div id="summary-contant">
			<h3 id="PurchasedPackageContents"> 1. Purchased Package Contents <a href="#toc">top</a></h3>
		
		<p>The Application Package you have downloaded Contain following files</p>
		<ul>
			<li>Documentation : HelpDocument.txt</li>
			<li>PHPScript (Admin Panel)</li>
			<li>Project File (FoodDelivery)</li>
			<li>Resources (Contains All PSD file</li>
			<li>New version changes : Version 1.0 changes.txt</li>
		</ul>
		<br>
		
	</div>


	<div id="summary-contant">
		<h3 id="GettingStartedWithIOSApp"> 2. How to import IOS Project ? <a href="#toc">top</a></h3>
		<p>You can install the CocoaPods tool on OS X by running the following command from the terminal.

		<p><i><b>$ sudo gem install cocoapods</i></b><p>
		
		<p>Open a terminal and cd to the directory containing the Podfile.

		<p><i><b>$ cd <path-to-project>/project/</i></b>
		<p>Run the pod install command. This will install the SDKs specified in the Podspec, along with any dependencies they may have.

		<p><i><b>$ pod install</b></i>
		<p>Open your app's .xcworkspace file to launch Xcode. Use this file for all development on your app.
		
		<br><br><img src="assets/images1/import1.png" alt="" />
	</div>

	<div id="summary-contant">
		<h3 id="GettingStartedWithIOSApp">
	
		<h3 id="ChangetheURLofData">3. Change Backend URL <a href="#toc">top</a></h3>
		
		<p>In Xcode Project, Locate <strong>Constants.h</strong> under <strong>FoodDelivery</strong></p>
		
		<p> In <b>link</b> replace url with your admin panel url.</p>
		
		<img src="assets/images1/ChangeURL.png" alt="" />
		
	</div>


	<div id="summary-contant">
		<h3 id="ShoHideAds">4. Show Hide Admob Advertisement <a href="#toc">top</a></h3>
 
		<li>To show and hide admob advertisement, Follow the below steps.
		<p>In Xcode Project, Locate <strong>Constants.h</strong> under <strong>FoodDelivery</strong></p>
		<b>TO SHOW ADS</b>
		<p>To show ads Change the value to YES (see screen shot)<br>
		<br><img src="assets/images1/showhideads.png" alt="" /><br>
		<b>TO HIDE ADS</b>
		<p>To show ads Change the value to NO (see screen shot)<br>
		<br><img src="assets/images1/showhideads1.png" alt="" /><br>
	</div>



	<div id="summary-contant">
	
		<h3 id="AdmobIntergration">5. Admob Integration : Change Admob ID - <a href="#toc">top</a></h3>
		
		    <p>You need two Admob ids <strong><li>1. Banner Ads and <li>2. for Full page Ads</strong>
		<p>In Xcode Project, Locate <strong>Constants.h</strong> under <strong>FoodDelivery</strong></p>
			<img src="assets/images1/AdmobChangeID.png" alt="" />
			<p>set your admob id here in <b>BannerID</b> and <b>InterstitialID</b> for Banner and Interstitial respectively.	
	</div>


	<div id="summary-contant">
		<h3 id="ChangeBundleIdentifier">6. Change Package Name <a href="#toc">top</a></h3>
			<p> Click on fooddelivery --> General tab <br><br>
			<img src="assets/images1/BundleIdentifierDemo.png" alt="" />
	</div>
	
	<div id="summary-contant">
		
		<h3 id="HowtoReskinApplication">8. How to Reskin Application <a href="#toc">top</a></h3><br>

		<h2>Change Icon</h2>
				<p>Open <a href="https://makeappicon.com">makeappicon</a> website and upload 1024 pixel icon,
				<p>download converted icon from your email. you will receive <b>AppIcon</b> folder.
				<p>Now open images.xcassets folder and remove old <b>AppIcon</b> and drag and drop new.
				
				<br><img src="assets/images1/reskinapp1.png" alt="" />
		<h2>Change Images</h2>
		<ul><li>In Xcode Project, Locate <strong>Resources -> Images
		<li>2. Replace images with the same name. 
		<ul><li>To Create new Images PSD file is also available in this package.</li></ul></ul>
	</div>


	<div id="summary-contant">
		<h3 id="LocalizeApp">9. Translate App in your language <a href="#toc">top</a></h3>
		<p>To Localize app in your language, Follow the steps 
		<li>1. From Left navigation bar select project StoreFinder.
		<li>2. Now Scroll down to localizations section in info.plist.
		<li>3. Click (+) plus icon add choose you language<br>
		<br><img src="assets/images1/localize1.png" alt="" /><br>

		<li>when below pop up open only select localizable.strings<br>

		<br><img src="assets/images1/localize2.png" alt="" /><br>

		<li>In Left Navigation bar you will find <b>Localizable.strings(English)</b>. Copy all words and paste in your file and change the meanings.

		<br><br>
	</div>
	
	<div id="summary-contant">
		<h3 id="setupadmin">10. Setup Admin Panel (backend) <a href="#toc">top</a></h3>
			<iframe class="card" width="700" height="415" src="https://www.youtube.com/embed/nEQvwZkrfwo" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		<br><br>
	</div>
	
	<div id="summary-contant">
		<h3 id="facebooklogin">11. How to setup Facebook Login ? <a href="#toc">top</a></h3>
		<li>1. Browse <a href="https://developers.facebook.com">https://developers.facebook.com</a> click <b>Add New App</b> add Name, email and continue.
				<br><br><img src="assets/images1/facebook1.png" alt="" /><br>
		<li>2. Go to Settings --> Basics --> Add Platform --> Select Android
		<br><br><img src="assets/images1/facebook2.png" alt="" /><br>
		<li>3. Copy Package Name from build.gradle file, set in field <b>Google Play Package Name</b><br>
		<br><br><img src="assets/images1/facebook3.png" alt="" /><br>
		
		<li>6. Now copy app id from facebook app page and set into <b>info.plist</b> file <b>FacebookAppID.</b><br>

		<br><br><img src="assets/images1/facebook6.png" alt="" /><br>

		<br><br>
	</div>
	
	<div id="summary-contant">
		<h3 id="setupgooglelogin">12. How to setup Google Login ? <a href="#toc">top</a></h3>
		
		<p>Goto <a href="https://firebase.google.com">google firebase</a> --> Click on <b>GO TO CONSOLVE</b>--> Add Project --> add Name & select country.
				
				<br><br><img src="assets/images1/google1.png" alt="" /><br>
						
		<P>Click on add firebase to ios app

		<p>Step 1 : Add your bundle identifier --> register app 
		<p>Step 2 : Download googleService file and add into xcode under <b>Supporting Files </b></b>
				<br><br><img src="assets/images1/google2.png" alt="" /><br>
		<p>Step 3 : skip
		<p>Step 4 : Finish
		<p>Now open GoolgeService-info.plist copy CLIENT_ID and set into Constants.h file <b>GClientID</b>
		<br><br><img src="assets/images1/google3.png" alt="" /><br>
		<p>Now open GoolgeService-info.plist copy REVERSED_CLIENT_ID and set into info.plist in URL types.
		<br><br><img src="assets/images1/google4.png" alt="" /><br>
	</div>
	<div id="summary-contant">
		<h3 id="howtocreatepushcertificate">11. How to create push certificate ? <a href="#toc">top</a></h3> 
		<h2>Configuring Your Apple Developer Account</h2> 
		<h4>Credit to <b>www.appcoda.com</b> for this tutorial  </h4>

		<p>The first step is to have a <a href="https://developer.apple.com/programs/">paid Apple developer account</a>. Yes, you need to enroll into the Apple Developer Program ($99 per year) to unlock the push notifications capability.</p>
		<p>Assuming you already got a paid developer account, go ahead and <a href="http://developer.apple.com/">login to your Apple Developer account</a>. Once logged in, you will be re-directed to the Apple Developer homepage. From there, you should see &ldquo;Account&rdquo; at the top navigation bar. Click that option.</p>
		<p>Now you should be inside of your Apple Developer account.</p>
		<p><img src="assets/images1/firebase-notification-apple-developer.png" /></p>
		<p>Now look to the left side bar. The third row should say &ldquo;Certificates, IDs &amp; Profiles.&rdquo; Select that option.</p>
		<p><img src="assets/images1/firebase-notification-certificate-option.png" /></p>
		<p>Now you are in the &ldquo;Certificates, Identifiers &amp; Profiles&rdquo; page.</p>
		<p><img class="aligncenter size-full wp-image-9757" src="assets/images1/firebase-notification-certificate-profile.png" /></p>
		<p>Look to left side bar and there should be a section called &ldquo;Identifiers.&rdquo; Under that section, there is a link that says &ldquo;App IDs.&rdquo; Press that.</p>
		<p>a link that says &ldquo;App IDs.&rdquo; Press that.</p>
		<div class="figure"><img class="aligncenter size-full wp-image-9759" src="assets/images1/firebase-notification-app-id.png" /></div>
		<p>You should see all your iOS App IDs.</p>
		<div class="figure"><img class="aligncenter size-full wp-image-9758" src="assets/images1/firebase-notification-app-id-2.png" /></div>
		<p>Now at the top right, you should see a <code>+</code> button. Press that. After that, you should be at this stage:</p>
		<div class="figure"><img class="aligncenter size-full wp-image-9760" src="assets/images1/firebase-notification-app-id-3.png" /></div>
		<p>We now need to fill out the followings:</p>

		<ul>
		<li><strong>App ID Description - Name</strong>. Here, you should put your app&rsquo;s name (e.g. Firebase Notification Demo)</li>
		<li><strong>App ID Suffix - Explicit App ID </strong>. Here, you need to select a unique bundle identifier for your app (e.g. com.appcoda.firebasenotificationsdemo). Please make sure you use your own bundle ID instead of using mine.</li>
		</ul>

		<p>Then under App Services, tick &ldquo;Push Notifications.&rdquo; Press continue.</p>
		<p>After that, you will be redirected to a &ldquo;Confirm your App ID&rdquo; page. Press register.</p>
		<p>Now we are back to our &ldquo;iOS App IDs&rdquo; page. Look for the App ID you just created. Press on it and you should see a a drop down of Application Services.</p>
		<p>Scroll down until you reach the end of the drop down and you should see an &ldquo;Edit&rdquo; button. Press that.</p>
		<p><img class="aligncenter size-full wp-image-9761" src="assets/images1/firebase-notification-push-enabled.png" /></p>
		<p>The &ldquo;iOS App ID Settings&rdquo; page will show up.</p>

		<div class="figure"><img class="aligncenter size-full wp-image-9762" src="assets/images1/firebase-notification-push-setting.png" /></div>
		<p>Scroll all the way down until you see &ldquo;Push Notifications.&rdquo;</p>
		<p>It is time for us to create a &ldquo;Client SSL Certificate.&rdquo; This will allow our notification server (Firebase) to connect to the Apple Push Notification Service. Under Development SSL Certificate, press on the &ldquo;Create Certificate&hellip;&rdquo; button.</p>
		<div class="figure"><img class="aligncenter size-full wp-image-9766" src="assets/images1/firebase-notification-push-ssl.png" /></div>
		<p>Now we will see this.</p>
		<p>&nbsp;</p>
		<div class="figure"><img class="aligncenter size-full wp-image-9765" src="assets/images1/firebase-notification-push-ssl-2.png"  /></div>
		<p>To generate a certificate, we would need a Certificate Signing Request (CSR) file from our Mac. We will get back to this page later, but now we need the CSR file.</p>
		
		<h2>Generating a CSR file</h2>
		<p>To generate a CSR file, press cmd + space and do a spotlight search for &ldquo;Keychain Access.&rdquo; Open Keychain Access, and go up to the menu to select <em>Keychain Access &gt; Certificate Assistant &gt; Request a Certificate From a Certificate Authority&hellip;</em></p>
		<img class="aligncenter size-full wp-image-9768" src="assets/images1/firebase-notification-keychainaccess.png" />
		<p>A &ldquo;Certificate Assistant&rdquo; pop up should appear.</p>
		<img class="aligncenter size-full wp-image-9767" src="assets/images1/firebase-notification-cert-assistant.png" />
		<p>Fill in your email address and name. Choose &ldquo;Saved to disk&rdquo; and press Continue. Then save your CSR somewhere on your hard drive.</p>
		
		<h2>Uploading Your CSR File</h2>
		<p>Now that we have our CSR generated, it is ready to go back to the &ldquo;Add iOS Certificate&rdquo; page.</p>
		<img  src="assets/images1/add-csr.png"  />
		<p>Scroll down. Press continue, and then click &ldquo;Choose file&hellip;&rdquo; Select the CSR file you just saved on your hard drive.</p>
		<img  src="assets/images1/add-csr-choose-file.png"  />
		<p>Next, click continue again. Then the web page should say &ldquo;Your certificate is ready.&rdquo;</p>
		<img  src="assets/images1/add-csr-ready.png"  />
		<p>Now you can go ahead and click on the blue download button to download your certificate.</p>
		<br>
		
		<h2>Preparing the APNs Certificate</h2>
		<p>Now that you have created the iOS certificate, we will then prepare the APNs (short for Apple Push Notifications) certificate, which will be used later in the Firebase configuration. Open up <em>Finder</em>and locate the certificate you downloaded earlier.</p>
		<p><img src="assets/images1/firebase-locate-cert.png" /></p>
		<p>Double click the certificate file (e.g. aps_development.cer) to add the certificate into Keychain Access.</p>
		<p>Now open up <em>Keychain Access</em>. Under the &ldquo;My Certificates&rdquo; category, you should see the certificate you just added. It should be called:</p>
		<p>Apple Development IOS Push Services : &lt;your.bundle.id&gt;
		<p>Click the expand arrow to the left of the certificate&rsquo;s name to reveal the private key option. Right click on the private key and press export.</p>
		<img  src="assets/images1/apns-export-cert.png"  />
		<p>Once clicking Export, a pop up will prompt you to save your private key as a <code>.p12</code> file. Go ahead and click save.</p>
		<img  src="assets/images1/apns-export-cert-2.png"  />
		<p>Then enter a password if you want to protect your exported certificate. Click OK to confirm.</p>
		<img src="assets/images1/apns-export-cert-3.png"  />
		<p>Awesome! We just completed the configuration and preparation. Now we are ready to move onto Firebase! Let&rsquo;s get started.</p>
	</div>
	
	<div id="summary-contant">
		<h3 id="setupfirebase">12. How to setup firebase ? <a href="#toc">top</a></h3>

		<p>First, head over to <a href="https://firebase.google.com/">Firebase console</a>. Sign in with your Google account to enter the console. If you don&rsquo;t know how to switch to the console, there is a button at the very top right that says &ldquo;Go to console.&rdquo; Go ahead and click on that.</p>
		<p><img src="assets/images1/firebase-console.png" /></p>
		<p>&nbsp;</p>
		<p>Once you are at the console, click on the &ldquo;CREATE A NEW PROJECT&rdquo; button.</p>
		<p>&nbsp;</p>
		<p><img src="assets/images1/firebase-new-proj.png" /></p>
		<p>I name my project &ldquo;Firebase Notification Demo&rdquo; but you&rsquo;re free to use other names. Simply click the &ldquo;CREATE A NEW PROJECT&rdquo; button to proceed.</p>
		<p><img src="assets/images1/firebase-name-project.png" /></p>
		<p>After that, you are redirected to the project overview page. Now click the &ldquo;Add Firebase to your iOS&rdquo; button. Enter your iOS bundle ID. Then click the &ldquo;ADD APP&rdquo; button.</p>
		<p><img src="assets/images1/firebase-add-app.png" /></p>
		<p>Follow the on-screen instruction to download the <code>GoogleInfo.plist</code> file. </p>
		<p><img src="assets/images1/firebase-download-plist.png" /></p>
		<p>Add <code>GoogleInfo.plist</code> file into xcode project. make sure you add exact place. when add also select Destination and Target as per below image.</p>
		<p><img src="assets/images1/plistfileadd.png" /></p>
		<p>Click &ldquo;continue&rdquo; to go to the next step. You will see instructions showing you how to add the Firebase SDK into our project. I will walk you through how to configure the SDK later. For now, just ignore and click &ldquo;Continue&rdquo; to proceed.</p>
		<p><img src="assets/images1/firebase-install-sdk.png" /></p>
		<p>Finally click &ldquo;Finish&rdquo; to complete the configuration. You should then see your iOS app in the Firebase overview page.</p>
		<p><img src="assets/images1/firebase-overview.png" /></p>
		<p>Look for the setting icon at the top right. Click the settings icon &gt; Project settings.</p>
		<p><img src="assets/images1/firebase-project-settings.png" /></p>
		<p>Select the <em>Cloud Messaging</em> tab.</p>
		<p>&nbsp;</p>
		<p><img src="assets/images1/firebase-cloud-messaging.png" /></p>
		<p>Scroll down, and click the &ldquo;Upload Certificate&rdquo; button.</p>
		<p><img src="assets/images1/firebase-cloud-messaging-2.png" /></p>
		<p>Then a pop should appear to ask you for your Development APNS certificate.</p>
		<p><img src="assets/images1/firebase-apns-cert.png" /></p>
		<p>Click browse and choose your APNs certificate (i.e. <code>.p12</code> file) that you prepared in the earlier section. If you configured the file with a password, enter certificate password, followed by clicking the Upload button.</p>
		<img  src="assets/images1/apns-export-cert-upload.png" />
		<p>Now you should see a Development APNs certificate file in the Cloud Messaging setting.</p>
		<img  src="assets/images1/apns-export-cert-upload-2.png"  />
		<p>ok its almost done now, go to Cloud Messaging setting and copy your server key.</p>
		<img  src="assets/images1/serverkey.png"  />
		<p>Now Open your admin panel</p>
		<p>Open Notification section from side menu</p>
		<p>Click on firebase key</p>
		<p>In ios firebasekey paste server key and save</p>
		<img  src="assets/images1/adminserverykey.png"  />
		<p>&nbsp;</p>
		<p>Now you can test push notification.. </p>
	</div>
	
        </center>
    </body>
</html>
