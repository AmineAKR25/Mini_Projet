import java.util.Scanner;
class TestAdresseIp {
    public static void main(String[] args) {
        AdresseIP adresse = new AdresseIP();
        Scanner scanner = new Scanner(System.in);
        System.out.println("Adresse IP par défaut : " + adresse);
        System.out.print("Entrez une adresse IP: ");
        String ipString = scanner.nextLine();
        adresse.setAdresseFromChaine(ipString, scanner);
        System.out.println("Adresse IP définie : " + adresse);
        for (int i = 0; i < 4; i++) {
            System.out.println("Octet " + i + ": " + adresse.getOctet(i));
        }
    }
}
