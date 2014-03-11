<%@ Page Language="C#" %>
<%@ Import Namespace="System.Web.Security" %>
<script runat="server">
public void Login_OnClick(object sender, EventArgs args) {
	if (FormsAuthentication.Authenticate(UsernameTextbox.Text, PasswordTextbox.Text)) {
		FormsAuthentication.RedirectFromLoginPage(UsernameTextbox.Text, NotPublicCheckBox.Checked);
	} else {
		Msg.Text = "Login failed. Please check your user name and password and try again.";
	}
}
</script>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
<form id="form1" runat="server">
  <h3>Login</h3>
  <asp:Label id="Msg" ForeColor="maroon" runat="server" /><br />
  Username: <asp:Textbox id="UsernameTextbox" runat="server" /><br />
  Password: <asp:Textbox id="PasswordTextbox" runat="server" TextMode="Password" /><br />
  <asp:Button id="LoginButton" Text="Login" OnClick="Login_OnClick" runat="server" />
  <asp:CheckBox id="NotPublicCheckBox" runat="server" /> 
  Check here if this is <span style="text-decoration:underline">not</span> a public computer.
</form>
</body>
</html>